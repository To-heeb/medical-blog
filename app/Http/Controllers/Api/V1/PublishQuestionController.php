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
        $this->authorize('create', Question::class);

        $question = $question->publish();

        return new QuestionResource($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $this->authorize('delete', Question::class);

        $question->unpublish();

        return response()->noContent();
    }
}
