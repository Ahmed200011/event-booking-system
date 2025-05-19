<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


route::controller(AuthenticationController::class)->group(function () {
    // Route::get('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::get('/profile', 'profile')->middleware('auth:sanctum');
    Route::post('/logout', 'logout')->middleware('auth:sanctum');
});


Route::prefix('admin')
    ->middleware(['auth:sanctum', 'role:administrator|superadministrator'])
    ->controller(AdminController::class)->group(function () {
        Route::post('/store/event', 'store');
        Route::put('/update/{id}/event', 'update');
        Route::delete('/delete/{id}/event', 'destroy');
        Route::get('/all/events', 'allEvents');
        Route::get('/all/booking', 'allEventsBooked');
    });


Route::apiResource('events', EventController::class)->middleware('auth:sanctum');
// Route::apiResource('bookings', BookingController::class)->middleware('auth:sanctum');

Route::prefix('user')
    ->middleware('auth:sanctum')
    ->controller(UserController::class)->group(function () {
        Route::post('/events', 'userEvents');
        Route::post('/bookEvent', 'store');
        Route::delete('/delete/{id}/event', 'destroy');
    });
