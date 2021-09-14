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
Route::middleware('auth') -> group(function(){
    Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])
        ->name('tasks');
    Route::post('/task/store', [\App\Http\Controllers\TaskController::class, 'store'])
        ->name('task.store');
    Route::get('/task/complete/{task}', [\App\Http\Controllers\TaskController::class, 'complete'])
        ->name('task.complete');
    Route::delete('task/delete/{task}', [\App\Http\Controllers\TaskController::class, 'delete'])
        ->name('task.delete');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
