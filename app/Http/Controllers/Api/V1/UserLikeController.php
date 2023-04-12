<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Like;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\LikeCollection;

class UserLikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        #$this->authorize('view-any', Like::class); 

        $search = $request->get('search', '');

        $likes = $user->likes()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new LikeCollection($likes);
    }
}
