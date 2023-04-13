<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TagController;
use App\Http\Controllers\Api\V1\LikeController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\AnswerController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\TagPostController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\PostLikeController;
use App\Http\Controllers\Api\V1\QuestionController;
use App\Http\Controllers\Api\V1\UserLikeController;
use App\Http\Controllers\Api\V1\UserPostController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\UserAnswerController;
use App\Http\Controllers\Api\V1\PostCommentController;
use App\Http\Controllers\Api\V1\UserCommentController;
use App\Http\Controllers\Api\V1\CategoryPostController;
use App\Http\Controllers\Api\V1\QuestionLikeController;
use App\Http\Controllers\Api\V1\UserQuestionController;
use App\Http\Controllers\Api\V1\QuestionAnswerController;
use App\Http\Controllers\Api\V1\RolePermissionController;
use App\Http\Controllers\Api\V1\UserPermissionController;
use App\Http\Controllers\Api\V1\Auth\NewPasswordController;
use App\Http\Controllers\Api\V1\Auth\VerifyEmailController;
use App\Http\Controllers\Api\V1\Auth\RegisteredUserController;
use App\Http\Controllers\Api\V1\Auth\PasswordResetLinkController;
use App\Http\Controllers\Api\V1\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\V1\Auth\EmailVerificationNotificationController;

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

    Route::post('/sanctum/token', [RegisteredUserController::class, 'store'])->name('token');

    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register');

    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login');

    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])->name('password.store');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['auth:sanctum', 'signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware(['auth:sanctum', 'throttle:6,1'])
        ->name('verification.send');


    Route::group([
        'middleware' =>  ['auth:sanctum'],
    ], function () {

        Route::apiResources([
            'users'         =>   UserController::class,
            'tags'          =>   TagController::class,
            'posts'         =>   PostController::class,
            'comments'      =>   CommentController::class,
            'questions'     =>   QuestionController::class,
            'answers'       =>   AnswerController::class,
            'roles'         =>   RoleController::class,
            'categories'    =>   CategoryController::class,
            'permissions'   =>   PermissionController::class,
        ]);

        Route::apiResource('likes', LikeController::class)->only(['store', 'destroy']);
        Route::apiResource('categories/{category}/posts', CategoryPostController::class)->only('store', 'index');
        Route::apiResource('tags/{tag}/posts', TagPostController::class);

        Route::name('roles.')
            ->group(function () {
                // Role Permissions
                Route::apiResource('roles/{role}/permissions', RolePermissionController::class)->except(['show', 'update']);
            });

        Route::name('users.')
            ->group(function () {
                // User Permissions
                Route::apiResource('users/{user}/permissions', UserPermissionController::class)->except(['show', 'update']);

                // User Posts
                Route::apiResource('users/{user}/posts', UserPostController::class)->only('store', 'index');

                // User Questions
                Route::apiResource('users/{user}/questions', UserQuestionController::class)->only(['index', 'store']);

                // User Comments
                Route::apiResource('users/{user}/comments', UserCommentController::class)->only('index');

                // User Answers
                Route::apiResource('users/{user}/answers', UserAnswerController::class)->only('index');

                // User Likes
                Route::apiResource('users/{user}/likes', UserLikeController::class)->only('index');
            });

        Route::name('posts.')
            ->group(function () {
                // Post Comments
                Route::apiResource('posts/{post}/comments', PostCommentController::class)->only('store', 'index');

                // Post Likes
                Route::apiResource('posts/{post}/likes', PostLikeController::class)->only(['store', 'index', 'destroy']);
            });

        Route::name('questions.')
            ->group(function () {
                // Post Comments
                Route::apiResource('questions/{question}/answers', QuestionAnswerController::class)->only('store', 'index');

                // Post Likes
                Route::apiResource('questions/{question}/likes', QuestionLikeController::class)->only(['store', 'index', 'destroy']);
            });

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });
});
