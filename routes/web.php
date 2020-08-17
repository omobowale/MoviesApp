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

Route::group(['middleware' => 'removebackhistory'], function(){


    Route::get('/', 'GenresController@index');

    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/movies/cart/{id}', 'CartController@add')->middleware('auth');

    Route::get('/movies/cart-show', 'CartController@showCart')->name('showcart')->middleware('auth');

    Route::get('/movies/cart-delete/{id}', 'CartController@deleteCartItem')->middleware('auth');

    Route::get('/showgenre', 'FilterController@showGroup')->middleware('auth');

    Route::resource('movies', 'MoviesController');
    Route::resource('genres', 'GenresController');
    Route::resource('profile', 'ProfileController')->middleware('auth');

    Route::get('purchase', 'PurchaseController@index')->name('purchase')->middleware('auth');

    Route::get('report', 'ReportController@index')->middleware('auth', 'role:admin');
    Route::get('report/monthlysales', 'ReportController@monthlysales')->middleware('auth', 'role:admin');

    Route::get('report/filter', 'ReportController@filter')->middleware('auth', 'role:admin');
    Route::post('report/filter', 'ReportController@filter2')->middleware('auth', 'role:admin');

    Route::post('/payment/add-funds/paypal', 'PaymentController@payWithpaypal')->middleware('auth');
    Route::get('status', 'PaymentController@getPaymentStatus')->name('status')->middleware('auth');

    Route::get('payment-info', 'PaymentController@paymentInfo')->name('payment-info')->middleware('auth');

});
