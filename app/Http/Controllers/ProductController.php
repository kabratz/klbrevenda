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
            ->with('categories')
            ->get();

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

            $categoriaAtual = Category::firstOrCreate(['name' => $row[11]])->id;

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
                        return response()->json(['success' => false, 'message' => 'Erro ao processar a imagem: ' . $e->getMessage()], 500);
                    }
                }
            }
        }
        return response()->json(['success' => true, 'message' => 'Produtos Inseridos com sucesso'], 200);
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
            return response()->json(['success' => true, 'message' => 'Product not found'], 404);
        }
    }

    /**
     * Undocumented function
     *
     * @param Request $request with the params
     */
    public function store(Request $request)
    {
        $product = new Product();
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

        $categories = $request->input('categoriesId');
        $product->categories()->sync($categories);

        $images = $request->input('images');
        if($images) {
            foreach ($images as $key => $image) {
                if ($image['file']){
                    $image = new Image();
                    $image->name = 'Image ' . ($key + 1);
                    $image->file = $image['file'];
                    $image->product_id = $product->id;
                    $image->save();
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Product created successfully', 'product' => $product], 201);
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

        if ($request->has('categoriesId')) {
            $categories = $request->input('categoriesId');
            $product->categories()->sync($categories);
        }

        if ($request->has('images')) {
            $images = $request->input('images');

            foreach ($images as $key => $image) {
                $imageId = $image['id'];
                if ($imageId) {
                    $imageModel = Image::findOrFail($imageId);
                    $imageModel->product_id = $product->id;
                    $imageModel->file = $image['file'];
                    $imageModel->save();
                    continue;
                }

                $imageModel = Image::create([
                    'id' => Str::uuid(),
                    'name' => 'Image ' . ($key + 1),
                    'file' => $image['file'],
                    'product_id' => $product->id,
                ]);
                $product->images[$key] = $imageModel;
            }
        }

        if ($request->has('imagesToRemove')) {
            $imagesToRemove = $request->input('imagesToRemove');

            foreach ($imagesToRemove as $key => $image) {
                $imageId = $image['id'];
                if ($imageId) {
                    $imageModel = Image::findOrFail($imageId);
                    $imageModel->delete();
                    continue;
                }
            }
        }

        return response()->json(['success' => true, 'message' => 'Product updated successfully', 'product' => $product->with('brand')->with('categories')]);
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
                $query->where('brands.id', $brandId);
            });
        }

        if ($categoryId) {
            $query->whereHas('categories', function ($query) use ($categoryId) {
                $query->where('categories.id', $categoryId);
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
