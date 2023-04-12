<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostCollection;

class UserPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view-any', Post::class);

        $search = $request->get('search', '');

        $posts = $user->posts()
            ->search($search)
            ->withCount('comments', 'likes')
            ->latest()
            ->paginate($request->input('limit', 5));

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|unique:questions',
            'content' => 'required',
            'published_at' => 'required|date|date_format:Y-m-d H:i:s',
            'slug' => 'unique:questions,slug',
        ]);

        $question = $user->posts()->create($validated);

        return new PostResource($question);
    }
}
