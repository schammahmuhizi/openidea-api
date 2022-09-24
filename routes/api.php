<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::fallback(function (){
    abort(404, 'Resource not found');
});

Route::middleware('auth:sanctum')->group(function() {
    Route::apiResource('users', UserController::class)->except(['store']);
    Route::apiResource('ideas', IdeaController::class);
    Route::post('ideas/{id}/like', [LikeController::class, 'like']);
    Route::post('ideas/{id}/unlike', [LikeController::class, 'unlike']);
    Route::post('ideas/{id}/comments', CommentController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);



