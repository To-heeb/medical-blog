<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\ModelViewed;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
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

            dd(Session::all());
            dd(Session::get('viewed_models'));
            $this->checkModelValidity($model, $modelId);
            #dd(Session::get('viewed_models', '{}'));


            if (!$this->hasViewedModel($model, $modelId)) {
                $model->increment('view_count');
                $this->storeViewedModel($model, $modelId);
            }
        }
    }

    protected function hasViewedModel($model, $modelId)
    {
        $viewedModels = json_decode(Session::get('viewed_models', '{}'), true);

        #dd(Session::get('viewed_models'));
        return isset($viewedModels[$model->getTable()][$modelId]);
    }

    protected function checkModelValidity($model, $modelId)
    {
        // Retrieve the data and check the timestamp
        $data = json_decode(Session::get('viewed_models', '{}'), true);
        if (isset($data[$model->getTable()][$modelId]) && Carbon::now()->gt($data[$model->getTable()][$modelId])) {

            // The data has expired, so remove it from the session
            Session::forget('viewed_models');

            return false;
        }

        return true;
    }

    protected function storeViewedModel($model, $modelId)
    {
        $viewedModels = json_decode(Session::get('viewed_models', '{}'), true);

        $expiresAt = Carbon::now()->addMinutes(2);
        $viewedModels[$model->getTable()][$modelId] = $expiresAt;

        #dd($viewedModels);
        Session::push('viewed_models', json_encode($viewedModels));
        #dd(Session::get('viewed_models'));
    }
}
