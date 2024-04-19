<?php

use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

Route::view('/','welcome');
Route::controller(UserController::class)
->name('users.')
->prefix('users')
->group(function(){
    Route::get('/','index')->name('index');
    Route::get('/create','index')->name('create');
    Route::get('/store','index')->name('store');
    Route::get('/{id}','index')->name('edit');
});

