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

// Route::get('/index', function () {
//     return view('welcome');
// });

Route::redirect('/', '/login');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/show', [App\Http\Controllers\Admin\UserStatusController::class, 'show'])->name('show');
Route::get('/showstatus', [App\Http\Controllers\Admin\UserStatusController::class, 'index'])->name('showstatus');
Route::get('/status/{id}', [App\Http\Controllers\Admin\UserStatusController::class, 'status'])->name('status');

//Resource route for User
Route::resource('users', App\Http\Controllers\Admin\UserController::class);
// Route for get Users for yajra post request.
Route::get('get-users', [App\Http\Controllers\Admin\UserController::class, 'getUsers'])->name('get-users');

//Resource route for Place
Route::resource('places', App\Http\Controllers\Admin\PlaceController::class);
// Route for get Places for yajra post request.
Route::get('get-places', [App\Http\Controllers\Admin\PlaceController::class, 'getPlaces'])->name('get-places');
