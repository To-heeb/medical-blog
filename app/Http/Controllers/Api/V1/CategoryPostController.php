<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\PostCollection;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category)
    {
        $this->authorize('view-any', Post::class);

        $search = $request->get('search', '');

        $posts = $category->posts()
            ->search($search)
            ->withCount('comments', 'likes')
            ->latest()
            ->paginate($request->input('limit', 5));

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Category $category)
    {
        $this->authorize('create', Post::class);

        $request->request->add([
            'user_id' => Auth::user()->id,
            'slug' => Str::slug($request->input('title'))
        ]);

        $validated = $request->validate([
            'title' => 'required|unique:questions',
            'content' => 'required',
            'published_at' => 'required|date|date_format:Y-m-d H:i:s',
            'slug' => 'required|unique:questions,slug',
            'user_id' => 'required|exists:users,id',
        ]);

        $post = $category->posts()->create($validated);

        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
