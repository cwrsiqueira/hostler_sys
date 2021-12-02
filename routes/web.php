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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/clients', [App\Http\Controllers\ClientController::class, 'index'])->name('clients');
    Route::post('/clients', [App\Http\Controllers\ClientController::class, 'store'])->name('clients.store');
    Route::put('/clients/{id}', [App\Http\Controllers\ClientController::class, 'update'])->name('clients.update');
    Route::delete('/clients/{id}', [App\Http\Controllers\ClientController::class, 'delete'])->name('clients.delete');

    Route::get('/projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
    Route::post('/projects', [App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
    Route::put('/projects/{id}', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
    Route::delete('/projects/{id}', [App\Http\Controllers\ProjectController::class, 'delete'])->name('projects.delete');
});
