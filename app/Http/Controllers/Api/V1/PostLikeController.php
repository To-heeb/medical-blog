<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeCollection;
use App\Http\Resources\LikeResource;

class PostLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Post $post)
    {
        //$this->authorize('view-any', Like::class); 

        $search = $request->get('search', '');

        $likes = $post->likes()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new LikeCollection($likes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        //$this->authorize('create', Like::class); 

        $like = $post->like();

        return new LikeResource($like);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //$this->authorize('delete', Like::class); 

        $post->unlike();

        return response()->noContent();
    }
}
