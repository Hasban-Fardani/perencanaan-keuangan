<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', App\Http\Controllers\HomeController::class)
        ->name('home');
    Route::resource('plans', App\Http\Controllers\PlanController::class)
        ->except(['index', 'create', 'edit']);
    Route::resource('plans.saving', App\Http\Controllers\SavingController::class)
        ->only(['store', 'destroy']);
});
