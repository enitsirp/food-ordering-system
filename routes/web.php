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
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::group(['prefix' => 'admin'], function() {

        /* CATEGORIES */
        Route::get('/categories', 'MenuCategoryController@index');
        Route::get('/categories/list', 'MenuCategoryController@list');
        Route::resource('/categories', 'MenuCategoryController');

        /* MENUS */
        Route::get('/categories/{category}/menus/list', 'MenuController@list');
        Route::resource('/categories/{category}/menus', 'MenuController');

        /* COUPONS */
        Route::get('/coupons/list', 'CouponController@list');
        Route::resource('/coupons', 'CouponController');
    });
});


Route::get('/orders/summary/{order}', 'HomeController@summary');
Route::get('/orders/{category}', 'HomeController@orders');
Route::post('/orders/process', 'HomeController@processOrder');
Route::post('/orders/checkout', 'HomeController@checkoutOrder');

