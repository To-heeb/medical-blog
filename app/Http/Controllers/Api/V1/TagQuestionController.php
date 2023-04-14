<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Tag;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionCollection;

class TagQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Tag $tag)
    {
        $this->authorize('view-any', Question::class);

        $search = $request->get('search', '');

        $questions = $tag->questions()
            ->search($search)
            ->withCount('answers', 'likes')
            ->latest()
            ->paginate($request->input('limit', 5));

        return new QuestionCollection($questions);
    }
}
