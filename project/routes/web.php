<?php

use App\Http\Controllers\GroupController;
use GuzzleHttp\Middleware;
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
    return view('home');
});

Route::middleware('auth')->group(function () {
    Route::resource('groups', GroupController::class)->parameters(['groups'=>'group:slug']);
    Route::resource('add-user', \App\Http\Controllers\UsersInGroupController::class)->parameters(['add-user' => 'group:id']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
