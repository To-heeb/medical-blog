<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;

class PublishPostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Post $post)
    {
        $this->authorize('create', Post::class);

        $post = $post->publish();

        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', Post::class);

        $post->unpublish();

        return response()->noContent();
    }
}
