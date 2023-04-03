<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\RolePermissionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
    'as' => 'api.'
], function () {

    // admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::post('/login', [AuthController::class, 'admin_login'])->name('login');
        Route::post('/register', [AuthController::class, 'admin_register'])->name('register');
    });

    // user
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::post('/login', [AuthController::class, 'user_login'])->name('login');
        Route::post('/register', [AuthController::class, 'user_register'])->name('register');
    });


    // admin
    Route::group([
        'prefix' => 'admin',
        'middleware' =>  ['auth:sanctum', 'role:super-admin'],
        'as' => 'admin.',
    ], function () {

        Route::apiResources([
            'roles'         =>   RoleController::class,
            'permissions'   =>   PermissionController::class,
        ]);

        Route::name('roles.')
            ->group(function () {
                // Role Permissions
                Route::apiResource('roles/{role}/permissions/{permission}', RolePermissionController::class)->only('store', 'destroy');
            });

        Route::name('users.')
            ->group(function () {
                // Role Permissions
                Route::apiResource('users/{user}/permissions/{permission}', UserPermissionController::class)->only('store', 'destroy');
            });
    });

    // user
});

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
