<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\UserController;
use App\Models\Comment;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/galleries', [GalleryController::class, 'index']);
Route::get('/authors/{user_id}', [UserController::class, 'userGalleries']);
Route::get('/galleries/{gallery}', [GalleryController::class, 'show']);



Route::middleware('guest')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});
Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('/galleries', [GalleryController::class, 'store']);
    Route::get('/my-galleries', [GalleryController::class, 'myGalleries']);
    Route::put('/galleries/{gallery}', [GalleryController::class, 'update']);
    Route::delete('/galleries/{gallery}', [GalleryController::class, 'destroy']);
    Route::post('/comments/{gallery}', [CommentController::class, 'store']);
    Route::delete('/comments/delete/{comment}', [CommentController::class, 'destroy']);
});
