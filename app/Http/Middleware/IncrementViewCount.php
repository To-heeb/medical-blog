<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class IncrementViewCount
{

    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $modelId = $request->route($this->model->getRouteKeyName());

        if ($modelId) {
            $model = $this->model->findOrFail($modelId);

            if (!$this->hasViewedModel($request, $this->model, $modelId)) {
                $model->increment('view_count');
                $this->storeViewedModel($request, $this->model, $modelId);
            }
        }

        return $next($request);
    }

    protected function hasViewedModel($request, $model, $modelId)
    {
        $viewedModels = json_decode(Cookie::get('viewed_models', '{}'), true);

        return isset($viewedModels[$model->getTable()][$modelId]);
    }

    protected function storeViewedModel($request, $model, $modelId)
    {
        $viewedModels = json_decode(Cookie::get('viewed_models', '{}'), true);

        $viewedModels[$model->getTable()][$modelId] = time();

        Cookie::queue('viewed_models', json_encode($viewedModels), 60 * 2);
    }
}
