<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use App\Models\Answer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AnswerCollection;

class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, User $user)
    {
        $this->authorize('view-any', Answer::class);

        $posts = $user->answers()
            ->latest()
            ->paginate($request->input('limit', 5));

        return new AnswerCollection($posts);
    }
}
