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
    Route::get('/', [\App\Http\Controllers\TaskController::class, 'index'])
        ->name('tasks');
    Route::get('/getTasks', [\App\Http\Controllers\TaskController::class, 'getTasks'])
        ->name('getTasks');
    Route::post('/task/store', [\App\Http\Controllers\TaskController::class, 'store'])
        ->name('task.store');
    Route::get('/task/complete/{task}', [\App\Http\Controllers\TaskController::class, 'complete'])
        ->name('task.complete');
    Route::delete('task/delete/{task}', [\App\Http\Controllers\TaskController::class, 'delete'])
        ->name('task.delete');
});
Route::get('test', function () {
    event(new App\Events\TaskAdded('Pysachuk'));
    return "Event has been sent!";
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
