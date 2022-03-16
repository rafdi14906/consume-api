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
    // return view('welcome');
    return redirect()->route('blog.index');
});

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@doLogin')->name('login.do');
Route::get('/register', 'AuthController@register')->name('register');
Route::post('/register', 'AuthController@doRegister')->name('register.do');

Route::middleware('auth.session')->group(function() {
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/blog', 'BlogController@index')->name('blog.index');
    Route::post('/blog', 'BlogController@store')->name('blog.store');
    Route::put('/blog/{id}', 'BlogController@update')->name('blog.update');
    Route::get('/blog/delete/{id}', 'BlogController@delete')->name('blog.delete');
});
