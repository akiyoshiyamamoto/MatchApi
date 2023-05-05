<?php

use App\Http\Controllers\AccountSettingController;
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
    Route::name('auth.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::name('user.')->prefix('user')->group(function () {
        Route::get('/', [UserController::class, 'show'])->name('show');
        Route::put('/', [UserController::class, 'update'])->name('update');
        Route::name('profile_image.')->group(function () {
            Route::get('/profile-images', [ProfileImageController::class, 'index'])->name('index');
            Route::post('/profile-image', [ProfileImageController::class, 'upload'])->name('upload');
            Route::delete('/profile-image/{id}', [ProfileImageController::class, 'delete'])->name('delete');
        });
        Route::post('/location', [UserController::class, 'updateLocation'])->name('location.update');
        Route::get('/nearby-users', [UserController::class, 'nearbyUsers'])->name('nearby_users');
        Route::get('/matched-users', [UserController::class, 'getMatchedUsers'])->name('matched_users');
    });

    Route::name('swipes.')->prefix('swipes')->group(function () {
        Route::post('/right', [SwipeController::class, 'rightSwipe'])->name('right');
        Route::post('/left', [SwipeController::class, 'leftSwipe'])->name('left');
    });

    Route::name('location.')->group(function () {
        Route::put('/location', [LocationController::class, 'update'])->name('update');
    });

    Route::name('notifications.')->group(function () {
        Route::get('/notifications/new-matches', [NotificationController::class, 'getNewMatchNotifications'])->name('new_matches');
    });

    Route::name('chats.')->prefix('chats')->group(function () {
        Route::get('/', [ChatController::class, 'getConversation'])->name('index');
        Route::post('/', [ChatController::class, 'store'])->name('store');
        Route::get('/{id}', [ChatController::class, 'show'])->name('show');
        Route::put('/{id}/read-status', [ChatController::class, 'updateReadStatus'])->name('updateReadStatus');
    });

    Route::name('account_settings.')->prefix('account_settings')->group(function () {
        Route::get('/{user_id}', [AccountSettingController::class, 'getAccountSetting'])->name('getAccountSetting');
    });
});
