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

//Resource route for Reservation of user
Route::resource('user-reservations', App\Http\Controllers\User\MakeReservationController::class);
Route::get('/make-userReservations', [App\Http\Controllers\User\MakeReservationController::class, 'store'])->name('make-userReservations');
// Route for get Reservations for yajra post request.
Route::get('get-userReservations', [App\Http\Controllers\User\MakeReservationController::class, 'getReservations'])->name('get-userReservations');

//Resource route for Reservation of admin
Route::resource('admin-reservations', App\Http\Controllers\Admin\ManageReservationController::class);
// Route::get('/make-userReservations', [App\Http\Controllers\User\MakeReservationController::class, 'store'])->name('make-userReservations');
// Route for get Reservations for yajra post request.
Route::get('get-adminReservations', [App\Http\Controllers\Admin\ManageReservationController::class, 'getReservations'])->name('get-adminReservations');

// Route for Waitlist of admin
Route::get('show-adminWaitlist', [App\Http\Controllers\Admin\ManageReservationController::class, 'showWaitList'])->name('show-adminWaitlist');
// Route for get Waitlist for yajra post request.
Route::get('get-adminWaitlist', [App\Http\Controllers\Admin\ManageReservationController::class, 'getWaitList'])->name('get-adminWaitlist');
