<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => 'test'], function() {
	Route::get('paypal/cancel', 'TestController@paypalCancel');
	Route::get('paypal/success', 'TestController@paypalSuccess');
	Route::get('paypal', 'TestController@paypal');
});

Route::get('/', 'HomepageController@index');

Route::group(['prefix' => 'order'], function() {
	Route::post('/', 'OrderCustomerController@store');

	Route::resource('collect', 'OrderCustomerController@collect');
	Route::resource('credentials', 'OrderCustomerController@getCredentials');
});

Route::group(['prefix' => 'product'], function() {
	Route::get('{product}/variations', 'ProductController@variations');
});

Route::group(['prefix' => 'file'], function() {
	Route::post('temporary/{type}', 'FileController@temporary');
});


// Customers Pages
Route::group(['middleware' => 'customer'], function() {

	Route::group(['prefix' => 'my'], function() {
		Route::group(['prefix' => 'orders'], function() {
			Route::get('/', 'OrderCustomerController@index')->name('customer.orders');
			Route::group(['prefix' => 'checkout'], function() {
				Route::get('{order}/cancel', 'OrderCustomerController@checkoutCancel');	   
				Route::get('{order}/success', 'OrderCustomerController@checkoutSuccess');
				Route::get('{order}', 'OrderCustomerController@checkout');
			});
		});

	  Route::get('credentials', 'CustomerController@credentials')->name('customer.credentials');
	});

});


//Customer Login
Route::get('customer/login', 'CustomerAuth\LoginController@showLoginForm');
Route::post('customer/login', 'CustomerAuth\LoginController@login');
Route::post('customer/logout', 'CustomerAuth\LoginController@logout');

//Customer Register
Route::get('customer/register', 'CustomerAuth\RegisterController@showRegistrationForm');
Route::post('customer/register', 'CustomerAuth\RegisterController@register');

//Customer Passwords
Route::post('customer/password/email', 'CustomerAuth\ForgotPasswordController@sendResetLinkEmail');
Route::post('customer/password/reset', 'CustomerAuth\ResetPasswordController@reset');
Route::get('customer/password/reset', 'CustomerAuth\ForgotPasswordController@showLinkRequestForm');
Route::get('customer/password/reset/{token}', 'CustomerAuth\ResetPasswordController@showResetForm');


//Admin Login
Route::get('admin/login', 'AdminAuth\LoginController@showLoginForm');
Route::post('admin/login', 'AdminAuth\LoginController@login');
Route::post('admin/logout', 'AdminAuth\LoginController@logout');

//Admin Register
Route::get('admin/register', 'AdminAuth\RegisterController@showRegistrationForm');
Route::post('admin/register', 'AdminAuth\RegisterController@register');

//Admin Passwords
Route::post('admin/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail');
Route::post('admin/password/reset', 'AdminAuth\ResetPasswordController@reset');
Route::get('admin/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
Route::get('admin/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');

