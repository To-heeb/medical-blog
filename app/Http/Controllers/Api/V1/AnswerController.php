<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerResource;
use App\Http\Resources\AnswerCollection;
use App\Http\Requests\Answer\StoreAnswerRequest;
use App\Http\Requests\Answer\UpdateAnswerRequest;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Answer::class);

        $search = $request->get('search', '');

        $answer = Answer::latest()
            ->paginate($request->input('limit', 5));

        return new AnswerCollection($answer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnswerRequest $request)
    {
        $this->authorize('create', Answer::class);

        $validated = $request->validated();

        $answer = Answer::create($validated);

        return new AnswerResource($answer);
    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        $this->authorize('view', $answer);

        return new AnswerResource($answer);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnswerRequest $request, Answer $answer)
    {
        $this->authorize('update', $answer);

        $validated = $request->validated();

        $answer->update($validated);

        return new AnswerResource($answer);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        $this->authorize('delete', $answer);

        $answer->delete();

        return response()->noContent();
    }
}
