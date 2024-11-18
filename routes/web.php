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

// Route::get('/', function () {
//     return view('welcome');
// });


use App\Http\Controllers\AuthController;

Route::controller(AuthController::class)->group(function(){
    Route::get('/registration','registration')->middleware('alreadyLoggedIn');
    Route::post('/registration-user','registerUser')->name('register-user');
    Route::get('/login','login')->middleware('alreadyLoggedIn');
    Route::post('/login-user','loginUser')->name('login-user');
    Route::get('/dashboard','dashboard')->middleware('isLoggedIn')->name('dashboard');
    Route::get('/logout','logout');
});


//Route::middleware('auth')->group(function () {

    Route::post('user_edit', [AuthController::class, 'user_edit'])->name('user_edit');
    Route::post('user_update', [AuthController::class, 'user_update'])->name('user_update');
    Route::post('user_delete', [AuthController::class, 'user_delete'])->name('user_delete');
    Route::post('user_new', [AuthController::class, 'user_new'])->name('user_new');
//});