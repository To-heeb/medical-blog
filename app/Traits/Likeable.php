<?php


namespace App\Traits;

use App\Models\Like;

trait Likeable
{

    /**
     * Create a like if it does not exist yet.
     */
    public function like(): Like
    {
        if ($this->likes()->where('user_id', auth()->id())->doesntExist()) {
            return $this->likes()->create(['user_id' => auth()->id()]);
        }
    }


    /**
     * Check if the resource is liked by the current user
     */
    public function isLiked(): bool
    {
        return $this->likes->where('user_id', auth()->id())->isNotEmpty();
    }

    /**
     * Delete like for a resource.
     */
    public function unlike(): Like
    {
        return $this->likes()->where('user_id', auth()->id())->get()->delete();
    }
}
