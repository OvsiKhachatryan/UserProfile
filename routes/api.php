<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EmailVerificationController;
use App\Http\Controllers\Api\UserController;
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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
})->middleware('auth:sanctum');

Route::controller(EmailVerificationController::class)->group(function () {
    Route::post('email/verification-notification', 'sendVerificationEmail');
    Route::get('verify-email/{id}/{hash}', 'verify')->name('verification.verify');
});

Route::middleware(['auth:sanctum', 'verified'])->controller(UserController::class)->group(function () {
    Route::get('/users', 'get')->name('users');
    Route::put('/user/edit', 'edit')->name('user.edit');
    Route::get('/users/by/age', 'getByAge')->name('users.by.age');
    Route::get('/users/by/city', 'getByCity')->name('users.by.city');
    Route::get('/users/search', 'search')->name('users.search');

    Route::post('/add/friend', 'addFriend')->name('add.friend');
    Route::get('/friend/request/bids', 'friendRequestBids')->name('friend.request.bids');
    Route::put('/friend/request/accept', 'acceptFriendRequest')->name('friend.request.accept');
    Route::put('/friend/request/decline', 'declineFriendRequest')->name('friend.request.decline');
});

