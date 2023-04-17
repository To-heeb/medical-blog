<?php

namespace App\Listeners;

use App\Events\ModelViewed;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateModelViewCount
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
    public function handle(ModelViewed $event): void
    {

        $modelId = $event->model->id;

        #dd($modelId);
        if (is_integer($modelId)) {

            $model = $event->model;

            if (!$this->hasViewedModel($model, $modelId)) {
                $model->increment('view_count');
                $this->storeViewedModel($model, $modelId);
            }
        }
    }

    protected function hasViewedModel($model, $modelId)
    {
        $viewedModels = json_decode(Cache::get('viewed_models', '{}'), true);

        #dd(Session::get('viewed_models'));
        return isset($viewedModels[$model->getTable()][$modelId]);
    }

    protected function storeViewedModel($model, $modelId)
    {
        $viewedModels = json_decode(Cache::get('viewed_models', '{}'), true);

        $viewedModels[$model->getTable()][$modelId] = time();

        #dd($viewedModels);Cache::put();
        Cache::put('viewed_models', json_encode($viewedModels), now()->addMinutes(1));
    }
}
