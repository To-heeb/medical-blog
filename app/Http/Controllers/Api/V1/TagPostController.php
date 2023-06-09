<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\PostCollection;

class TagPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Tag $tag)
    {
        $this->authorize('view-any', Post::class);

        $search = $request->get('search', '');

        $posts = $tag->posts()
            ->search($search)
            ->withCount('comments', 'likes')
            ->latest()
            ->paginate($request->input('limit', 5));

        return new PostCollection($posts);
    }
}
