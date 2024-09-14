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
    private $myContact = '551981472522';
    
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
                'discount_percent' => 0,
            ]);

            $orderSummary = '';

            foreach ($validatedData['cart'] as $cartItem) {
                $product = Product::findOrFail($cartItem['id']);

                OrdersProduct::create([
                    'id' => (string) Str::uuid(),
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                    'discount' => 0,
                    'discount_percent' => 0,
                ]);

                $product->quantity -= $cartItem['quantity'];
                $product->save();
                
                $orderSummary .= "{$product->name} - {$cartItem['quantity']} x {$cartItem['price']} = " . ($cartItem['quantity'] * $cartItem['price']) . " \n";
            }


            // Criar o link para enviar a mensagem no WhatsApp
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
}
