<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::middleware('auth') -> group(function(){
    Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])
        ->name('tasks');
    Route::get('/getTasks', [\App\Http\Controllers\TaskController::class, 'getTasks'])
        ->name('getTasks');
    Route::post('/task/store', [\App\Http\Controllers\TaskController::class, 'store'])
        ->name('task.store');
    Route::post('/task/complete', [\App\Http\Controllers\TaskController::class, 'complete'])
        ->name('task.complete');
    Route::delete('/task/delete', [\App\Http\Controllers\TaskController::class, 'delete'])
        ->name('task.delete');
});

