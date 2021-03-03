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

//Route::get('/', function () {
//    return view('home');
//});


Route::get('/', 'HomeController@index')->name("Home");
Route::get('/store/{catSlug?}', 'StoreController@index')->name("Store");

Route::get('/about-us', 'AboutUsController@index')->name("AboutUs");
Route::get('/contact', 'ContactUsController@index')->name("ContactUs");

Route::get('/product/{slug}', 'ProductController@index')->name("Product");

Route::post('/product/{slug}', 'ProductController@lazyProduct')->name("LazyProduct");

Route::get('/lazy-store', 'StoreController@lazyLoadIndex')->name("LazyStore");


Route::post('/email', 'EmailController@sendEmail')->name("Email");

