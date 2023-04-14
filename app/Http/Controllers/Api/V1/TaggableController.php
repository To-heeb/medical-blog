<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tag;
use App\Models\Post;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;


class TaggableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Tag $tag)
    {
        $this->authorize('view-any', [Post::class, Question::class]);


        // Retrieve all posts and questions that have the given tag
        $posts = $tag->posts()->get()->append(['type' => 'post']);
        $questions = $tag->questions()->get()->append(['type' => 'post']);

        // Merge the collections and paginate the results
        $taggables = $posts->merge($questions);
        $perPage = 10;
        $page = $request->input('page', 1);
        $offset = ($page - 1) * $perPage;
        $paginatedTaggables = new LengthAwarePaginator(
            $taggables->slice($offset, $perPage),
            $taggables->count(),
            $perPage,
            $page,
            [
                'url' => url()->current()
            ]
        );
        $paginatedTaggables = collect($paginatedTaggables);
        $data = $paginatedTaggables->get('data');
        $paginatedTaggables->forget('data');

        // Return the results as a JSON response
        return response()->json([
            'tag' => $tag,
            'data' => $data,
            'meta' => $paginatedTaggables,
        ]);
    }
}
