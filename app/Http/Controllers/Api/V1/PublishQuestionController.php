<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Question;
use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionResource;

class PublishQuestionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Question $question)
    {
        $this->authorize('create', $question);

        // $request->validate([
        //     'question_id' => 'required|exists:questions,id',
        // ]);

        // $question = Question::findOrFail($request->input('question_id'));

        $question->publish();

        return new QuestionResource($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', $question);

        $question->unpublish();

        return new QuestionResource($question);
    }
}
