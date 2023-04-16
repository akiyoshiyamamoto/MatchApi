<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileImageController;
use App\Http\Controllers\SwipeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');


Route::middleware('jwt.check')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('show');
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::get('/profile-images', [ProfileImageController::class, 'index']);
        Route::post('/profile-image', [ProfileImageController::class, 'upload']);
        Route::delete('/profile-image/{id}', [ProfileImageController::class, 'delete']);
        Route::post('/location', [UserController::class, 'updateLocation']);
        Route::get('/nearby-users', [UserController::class, 'nearbyUsers']);
        Route::get('/matched-users', [UserController::class, 'getMatchedUsers']);
    });

    Route::prefix('swipes')->group(function () {
        Route::post('/right', [SwipeController::class, 'rightSwipe'])->name('swipes.right');
        Route::post('/left', [SwipeController::class, 'leftSwipe'])->name('swipes.left');
    });

    Route::put('/location', [LocationController::class, 'update'])->name('location.update');
    Route::get('/notifications/new-matches', [NotificationController::class, 'getNewMatchNotifications']);

    Route::prefix('chats')->group(function () {
        Route::get('/', [ChatController::class, 'getConversation'])->name('index');
        Route::get('/{id}', [ChatController::class, 'show'])->name('show');
    });
});
