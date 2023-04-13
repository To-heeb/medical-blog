<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Http\Resources\LikeCollection;

class QuestionLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Question $question)
    {
        //$this->authorize('view-any', Like::class); 

        $search = $request->get('search', '');

        $likes = $question->likes()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new LikeCollection($likes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Question $question)
    {
        //$this->authorize('create', Like::class); 

        $like = $question->like();

        return new LikeResource($like);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //$this->authorize('delete', Like::class); 

        $question->unlike();

        return response()->noContent();
    }
}
