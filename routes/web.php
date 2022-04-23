<?php

use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\DeviceController;

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

Route::middleware('auth')->group(function (){
  Route::get('/home', 'HomeController@index')->name('home');
  Route::resource('/device', 'DeviceController')->only(['index', 'show', 'store', 'create',]);
  Route::resource('/location', 'LocationController')->except(['create', 'store', 'update']);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
