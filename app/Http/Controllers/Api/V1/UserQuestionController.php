<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;

class UserQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,  User $user)
    {
        $this->authorize('view-any', Question::class);

        $search = $request->get('search', '');

        $questions = $user->questions()
            ->search($search)
            ->withCount('answers', 'likes')
            ->latest()
            ->paginate($request->input('limit', 5));

        return new QuestionCollection($questions);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Question::class);

        $validated = $request->validate([
            'title' => 'required|unique:questions',
            'content' => 'required',
            'published_at' => 'required|date|date_format:Y-m-d H:i:s',
            'slug' => 'unique:questions,slug',
        ]);

        $question = $user->questions()->create($validated);

        return new QuestionResource($question);
    }
}
