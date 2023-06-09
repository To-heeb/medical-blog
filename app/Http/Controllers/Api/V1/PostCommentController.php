<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentCollection;

class PostCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Post $post)
    {
        $this->authorize('view-any', Comment::class);

        $search = $request->get('search', '');

        $comments = $post->comments()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new CommentCollection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Post $post)
    {
        $this->authorize('create', Comment::class);

        $request->request->add(['user_id' => Auth::user()->id]);

        $validated = $request->validate([
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $comment = $post->comment()->create($validated);

        return new CommentResource($comment);
    }
}
