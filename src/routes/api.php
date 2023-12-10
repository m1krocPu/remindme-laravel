<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\ReminderController;

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

Route::prefix('session')->controller(SessionController::class)->group(function(){
    Route::post('/', 'createSession');
    Route::put('/', 'refreshSession');
});

Route::middleware('session.auth')->group(function() {
    Route::prefix('reminders')->controller(ReminderController::class)->group( function() {
        Route::get('/', 'index');
        Route::post('/', 'store');
        Route::get('/{id}', 'detail');
        Route::put('/{id}', 'update');
    });
});
