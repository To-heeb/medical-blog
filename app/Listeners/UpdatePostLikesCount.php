<?php

namespace App\Listeners;

use App\Events\LikeUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateModelLikesCount
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LikeUpdated $event): void
    {
        $like = $event->like;
        $model = $like->likeable;

        if ($like->wasRecentlyCreated) {
            // Increment likes_count if a new like was added
            $model->increment('likes_count');
        } else {
            // Decrement likes_count if a like was deleted
            $model->decrement('likes_count');
        }
    }
}
