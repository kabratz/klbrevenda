<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all()->toArray();

        // Construir a árvore de categorias
        $categoryTree = $this->buildCategoryTree($categories);
        return response()->json($categoryTree);
    }

    public function all()
    {
        $categories = Category::all()->toArray();

        return response()->json($categories);
    }

    function buildCategoryTree($categories, $parentId = null)
    {
        $branch = [];

        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                $children = $this->buildCategoryTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $branch[] = $category;
            }
        }

        return $branch;
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input('name');
        $category->save();

        return response()->json($category);
    }

    /**
     * Delete a category with the informed id
     *
     * @param string $id Category Id to delete
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->delete();
            return response()->json(['success' => true,'message' => 'Category deleted successfully'], 200);
        }
        return response()->json(['success' => false,'message' => 'Category not found'], 404);
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
            'parent_id' => 'nullable|string',
        ]);

        $category = new Category();
        $category->name = $request->input('name');
        $category->parent_id = $request->input('parent_id');
        $category->save();

        return response()->json(['success' => true,'message' => 'Category created successfully', 'category' => $category], 201);
    }
}
