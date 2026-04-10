<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Resources\ArticleResource; 

class ArticleController extends Controller
{
    // GET /api/articles
    public function index(Request $request)
    {
        $articles = Article::with(['user', 'category'])
            ->latest()
            ->paginate(5);

    // SEARCH
    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }
    
     

        return ArticleResource::collection($articles);  
    }

    // POST /api/articles
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
            'category_id' => 'nullable|exists:categories,id'
        ]);
        // dd($request->all());
        $article = Article::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->content,
            'slug' => Str::slug($request->title)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Article Created',
            'data' => $article
        ], 201);
    }

    // GET /api/articles/{id}
    public function show($id)
    {
        $article = Article::with(['user', 'category'])
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Article',
            'data' => $article
        ]);
    }

    // PUT /api/articles/{id}
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'content' => 'sometimes|required',
            'category_id' => 'nullable|exists:categories,id'
        ]);

        $article->update([
            'title' => $request->title ?? $article->title,
            'content' => $request->content ?? $article->content,
            'category_id' => $request->category_id ?? $article->category_id,
            'slug' => Str::slug($request->title ?? $article->title)
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Article Updated',
            'data' => $article
        ]);
    }

    // DELETE /api/articles/{id}
    public function destroy($id)
    {
        Article::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Article Deleted'
        ]);
    }
}
