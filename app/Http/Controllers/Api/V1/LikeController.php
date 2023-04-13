<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use Illuminate\Support\Str;
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

        #$this->authorize('create', Like::class);

        $request->request->add(['likeable_type' => Str::upper("app\models\/$request->input('likeable_type')")]);

        $validated = $request->validated();

        $user = Like::create($validated);

        return new LikeResource($user);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        #$this->authorize('delete', Like::class);

        $like->delete();

        return response()->noContent();
    }
}
