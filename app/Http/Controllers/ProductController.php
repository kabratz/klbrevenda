<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Models\ProductsHasCategory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('brand')
            ->with('images')
            ->with(['categories' => function ($query) {
                $query->with('parent');
            }])
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id ?? '',
                    'name' => $product->name ?? '',
                    'quantity' => $product->quantity ?? '',
                    'description' => $product->description ?? '',
                    'price' => $product->price ?? '',
                    'gender' => $product->gender ?? '',
                    'google_product_category' => $product->google_product_category ?? '',
                    'fb_product_category' => $product->fb_product_category ?? '',
                    'sku' => $product->sku ?? '',
                    'brand' => $product->brand ? [
                        'id' => $product->brand->id ?? '',
                        'name' => $product->brand->name ?? '',
                    ] : [
                        'id' => '',
                        'name' => ''
                    ],
                    'images' => $product->images->map(function ($image) {
                        return [
                            'id' => $image->id ?? '',
                            'file' => $image->file ?? '',
                            'name' => $image->name ?? '',
                        ];
                    }),
                    'categories' => $product->categories->map(function ($category) {
                        return [
                            'id' => $category->id ?? '',
                            'name' => $category->name ?? '',
                            'parent' => $category->parent ? [
                                'id' => $category->parent->id ?? '',
                                'name' => $category->parent->name ?? '',
                            ] : [
                                'id' => '',
                                'name' => ''
                            ],
                        ];
                    }),
                ];
            });

        $brands = Brand::all();

        $categories = Category::all();
        return response()->json([
            'products' => $products,
            'brands' => $brands,
            'categories' => $categories
        ]);
    }


    public function import()
    {
        return view('import-products');
    }

    public function importFromCsv(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $csvData = array_map('str_getcsv', file($file));

        foreach ($csvData as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $brand = Brand::firstOrCreate(['name' => $row[7]]);

            $product = Product::updateOrCreate(
                ['sku' => $row[8]],
                [
                    'name' => $row[0],
                    'description' => $row[1],
                    'price' => $row[2],
                    'quantity' => $row[3],
                    'google_product_category' => $row[4],
                    'fb_product_category' => $row[5],
                    'gender' => $row[6],
                    'brand_id' => $brand->id,
                ]
            );

            ProductsHasCategory::firstOrCreate([
                'product_id' => $product->id,
                'category_id' => $row[11],
            ]);
            
            $categoriaAtual = Category::find($row[11])->parent_id;

            while ($categoriaAtual) {
                ProductsHasCategory::firstOrCreate([
                    'product_id' => $product->id,
                    'category_id' => $categoriaAtual,
                ]);
                
                $categoriaAtual = Category::find($categoriaAtual)->parent_id;
            }
            
            $imageUrls = [$row[9], $row[10]];



            foreach ($imageUrls as $index => $url) {
                if (!empty($url)) {
                    try {
                        $imageContents = @file_get_contents($url);

                        if ($imageContents === false) {
                            continue;
                        }

                        $fileName = Str::uuid() . '.' . pathinfo($url, PATHINFO_EXTENSION);

                        $filePath = 'products/' . $fileName;

                        Storage::disk('public')->put($filePath, $imageContents);

                        Image::create([
                            'name' => 'Image ' . ($index + 1),
                            'file' => $filePath,
                            'product_id' => $product->id,
                        ]);
                    } catch (\Exception $e) {
                        dd($e->getMessage());
                        // Tratar erros de download ou salvamento
                        //\Log::error('Erro ao processar a imagem: ' . $e->getMessage());
                    }
                }
            }
        }

        return redirect()->back()->with('success', 'Products imported successfully!');
    }

    /**
     * Delete a product with the informed id
     *
     * @param string $id Product Id to delete
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return response()->json(['message' => 'Product deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Product not found'], 404);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request with the params
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer',
            'google_product_category' => 'nullable|string',
            'fb_product_category' => 'nullable|string',
            'gender' => 'nullable|string|in:male,female,unisex',
            'brand_id' => 'required|exists:brands,id',
            'sku' => 'string|max:20',
        ]);

        $product = new Product();
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->google_product_category = $request->input('google_product_category');
        $product->fb_product_category = $request->input('fb_product_category');
        $product->gender = $request->input('gender');
        $product->brand_id = $request->input('brand_id');
        $product->save();

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Update the informed product
     *
     * @param Request $request
     * @param string $id Product Id
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        
        $product = Product::findOrFail($id);
        //dd($product);
        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->price = $request->input('price');
        $product->quantity = $request->input('quantity');
        $product->google_product_category = $request->input('google_product_category');
        $product->fb_product_category = $request->input('fb_product_category');
        $product->gender = $request->input('gender');
        $product->brand_id = $request->input('brand_id');
        $product->sku = $request->input('sku');
        $product->save();

        if ($request->has('images')) {
            $images = $request->input('images');

            foreach ($images as $key => $image) {
                $imageId = $image['id'];
                if ($imageId)
                {
                    $imageModel = Image::findOrFail($imageId);
                    $imageModel->product_id = $product->id;
                    $imageModel->file = $image['file'];
                    $imageModel->save();
                    continue;
                }

                $imageModel = Image::create([
                    'id' => Str::uuid(),
                    'name' => $image['name'],
                    'file' => $image['file'],
                    'product_id' => $product->id,
                ]);
                $product->images[$key] = $imageModel;
            }
        }


        return response()->json(['success' => true, 'message' => 'Product updated successfully', 'product' => $product]);
    }


    public function filter(Request $request)
    {
        $request->validate([
            'brand_id' => 'nullable|uuid',
            'category_id' => 'nullable|uuid',
            'search' => 'nullable|string',
        ]);

        $brandId = $request->input('brand_id');
        $categoryId = $request->input('category_id');
        $search = $request->input('search');

        $query = Product::with('brand', 'categories', 'images');

        if ($brandId) {
            $query->whereHas('brand', function ($query) use ($brandId) {
                $query->where('brands.id', $brandId); // Especifica a tabela 'brands'
            });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId); // Especifica a tabela 'categories'
            });
        }

        if ($search) {
            $query->where('name', 'ilike', '%' . $search . '%');
        }

        $products = $query->get();

        return response()->json($products);
    }

    public function uploadImage(Request $request, $id)
    {
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            return response()->json(['success' => true, 'imageUrl' => $path]);
        }
        return response()->json(['success' => false], 400);
    }
}
