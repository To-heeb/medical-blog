<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeCollection;

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
    public function store(Request $request)
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
