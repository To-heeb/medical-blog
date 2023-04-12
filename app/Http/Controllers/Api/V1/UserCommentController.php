<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CommentCollection;

class UserCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view-any', Comment::class);

        $search = $request->get('search', '');

        $posts = $user->comments()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new CommentCollection($posts);
    }
}
