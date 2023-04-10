<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeResource;
use App\Http\Requests\Like\StoreLikeRequest;
use App\Http\Requests\Like\UpdateLikeRequest;

class LikeController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLikeRequest $request)
    {
        $validated = $request->validated();

        $user = Like::create($validated);

        return new LikeResource($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        $like->delete();

        return response()->noContent();
    }
}
