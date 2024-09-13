<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::all();

        return response()->json($brands);
    }

    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        $brand->name = $request->input('name');
        $brand->save();

        return response()->json(['success' => true, 'brand' => $brand]);
    }

    /**
     * Delete a brand with the informed id
     *
     * @param string $id Brand Id to delete
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->delete();
            return response()->json(['success' => true, 'message' => 'Brand deleted successfully'], 200);
        }
        return response()->json(['success' => false, 'message' => 'Brand not found'], 404);
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
        ]);

        $brand = new Brand();
        $brand->name = $request->input('name');
        $brand->save();

        return response()->json(['success' => true, 'message' => 'Brand created successfully', 'brand' => $brand], 201);
    }
}
