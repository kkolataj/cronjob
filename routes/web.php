<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ConfigController;

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

Route::post('user-settings', [BookController::class, 'update']);

Route::get('/user-settings/{id}', [BookController::class, 'showItemById']);

Route::get('/user-settings/latest-rate/{currency}', [BookController::class, 'getLatestRate']);

// Route::get('/', function () {
//     return view('vue');
// });

Route::get('/', function () {
    return view('welcome');
});


// Route::group(['namespace' => 'App\Http\Controllers', 'middleware' => 'cors'], function()
// {
//     /**
//      * Home Routes
//      */
//     Route::get('/', 'HomeController@index')->name('home.index');

//     Route::post('/', 'HomeController@store')->name('home.store');

//     Route::group(['middleware' => ['guest']], function() {
//         /**
//          * Register Routes
//          */
//         Route::get('/register', 'RegisterController@show')->name('register.show');
//         Route::post('/register', 'RegisterController@register')->name('register.perform');

//         /**
//          * Login Routes
//          */
//         Route::get('/login', 'LoginController@show')->name('login.show');
//         Route::post('/login', 'LoginController@login')->name('login.perform');

//     });

//     Route::group(['middleware' => ['auth']], function() {
//         /**
//          * Logout Routes
//          */
//         Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
//     });
// });


