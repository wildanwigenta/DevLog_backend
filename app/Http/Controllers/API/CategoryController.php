<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // GET /api/categories
    public function index()
    {
        $categories = Category::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Categories',
            'data' => $categories
        ]);
    }

    // POST /api/categories
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category Created',
            'data' => $category
        ], 201);
    }

    // GET /api/categories/{id}
    public function show($id)
    {
        $category = Category::findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Category',
            'data' => $category
        ]);
    }

    // PUT /api/categories/{id}
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|string|max:255'
        ]);

        $category->update([
            'name' => $request->name ?? $category->name,
            'slug' => Str::slug($request->name ?? $category->name)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category Updated',
            'data' => $category
        ]);
    }

    // DELETE /api/categories/{id}
    public function destroy($id)
    {
        Category::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Category Deleted'
        ]);
    }
}
