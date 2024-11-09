<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrdersProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    private $myContact = '5551981472522';


    private function getDiscountPercent(int $quantityItems = 0)
    {
        if ($quantityItems == 1) {
            return 5;
        }
        if ($quantityItems == 2) {
            return 10;
        }
        if ($quantityItems >= 3) {
            return 15;
        }
        return 0;
    }

    public function create(Request $request)
    {
        // Validação dos dados do request
        $validatedData = $request->validate([
            'cart' => 'required|array|min:1',
            'customer.name' => 'required|string|max:100',
            'customer.whatsapp' => 'required|string|max:14',
        ]);


        try {
            $customer = Client::where('whatsapp', $validatedData['customer']['whatsapp'])->first();
            if (!$customer) {
                $customer = Client::create([
                    'id' => Str::uuid(),
                    'name' => $validatedData['customer']['name'],
                    'whatsapp' => $validatedData['customer']['whatsapp']
                ]);
            }


            $order = Order::create([
                'id' => (string) Str::uuid(),
                'client_id' => $customer->id,
                'discount_percent' => $this->getDiscountPercent(count($validatedData['cart'])),
            ]);

            $orderSummary = '';

            $totalPrice = 0;
            $totalDiscount = 0;
            $totalPriceWithDiscount = 0;

            foreach ($validatedData['cart'] as $cartItem) {
                $product = Product::findOrFail($cartItem['id']);

                if ($product->quantity < $cartItem['quantity']) {
                    return response()->json([
                        'message' => 'Product out of stock',
                        'product' => $product->name,
                        'quantity_available' => $product->quantity,
                    ], 400);
                }

                $orderProduct = OrdersProduct::create([
                    'id' => (string) Str::uuid(),
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem['quantity'],
                    'price' => $product->price,
                    'discount' => 0,
                    'discount_percent' => 0,
                ]);

                $product->quantity -= $cartItem['quantity'];
                $product->save();

                $itemPrice = $orderProduct->quantity * $orderProduct->price;
                $orderSummary .= "{$product->name} - {$orderProduct->quantity} x {$orderProduct->price} = " . ($itemPrice) . " \n";

                $totalPrice += $itemPrice;
            }


            $totalDiscount = ($order->discount_percent / 100) * $totalPrice;
            $totalPriceWithDiscount = $totalPrice - $totalDiscount;

            // Criar o link para enviar a mensagem no WhatsApp
            $orderSummary .= "\nTotal: R$ " . number_format($totalPrice, 2, ',', '.');
            $orderSummary .= "\nDesconto: - R$ " . number_format($totalDiscount, 2, ',', '.');
            $orderSummary .= "\nTotal com desconto: *R$ " . number_format($totalPriceWithDiscount, 2, ',', '.') . "*";
            $whatsappMessage = urlencode("Oi! Realizei meu pedido pelo site.\n\nSegue o resumo do pedido:\n" . $orderSummary);
            $whatsappLink = "https://wa.me/{$this->myContact}?text={$whatsappMessage}";


            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
                'whatsapp_link' => $whatsappLink,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error creating order',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function index()
    {
        $orders = Order::with('client', 'ordersProduct.product')->get();

        $orders = $orders->map(function ($order) {
            $order->total = $order->ordersProduct->sum(function ($orderProduct) {
                return $orderProduct->quantity * $orderProduct->price;
            });

            $order->totalWithDiscount = $order->ordersProduct->sum(function ($orderProduct) use ($order) {
                return $orderProduct->quantity * $orderProduct->price * ((100 - $order->discount_percent) / 100);
            });

            return $order;
        });


        return response()->json($orders);
    }
}
