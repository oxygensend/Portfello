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
    Route::resource('groups.add-user', \App\Http\Controllers\UsersInGroupController::class);
    Route::resource('groups.expenses', App\Http\Controllers\GroupExpenseController::class);

    Route::post('/invites/accept/{invite}','App\Http\Controllers\InvitesController@accept')->name('invites.accept');
    Route::delete('/invites/delete/{invite}', 'App\Http\Controllers\InvitesController@delete')->name('invites.delete');
    Route::get('/history', \App\Http\Controllers\HistoryServiceController::class)->name('history');;
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/logout', 'App\Http\Controllers\LogoutController@logout');
    Route::get('/edit-user','App\Http\Controllers\EditUserController@index');
});



require __DIR__.'/auth.php';
