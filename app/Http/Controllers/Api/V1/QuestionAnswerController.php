<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AnswerCollection;

class QuestionAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Question $question)
    {
        $this->authorize('view-any', Answer::class);

        $search = $request->get('search', '');

        $answers = $question->answers()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new AnswerCollection($answers);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Question $question)
    {
        $this->authorize('create', Answer::class);

        $request->request->add(['user_id' => Auth::user()->id]);

        $validated = $request->validate([
            'content' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        $answer = $question->answers()->create($validated);

        return new AnswerResource($answer);
    }
}
