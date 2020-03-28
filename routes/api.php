<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1'], function () {

    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');

    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    });

    Route::group(['middleware' => ['jwt.verify']], function () {

        Route::resource('users', 'UserController');
        Route::group(['prefix' => 'users'], function () {
            Route::get('/{user}', 'userController@show');
            Route::get('/{user}/profile', 'UserController@getUserProfile');
        });

        Route::get('user', 'AuthController@getAuthUser');
        Route::get('user/profile', 'UserController@getAuthenticatedProfile');

        Route::resource('profiles', 'UserProfileController');
        Route::group(['prefix' => 'profiles'], function () {
        });

        Route::resource('suppliers', 'SupplierController');
        Route::group(['prefix' => 'suppliers'], function () {
        });

        Route::resource('categories', 'CategoryController');
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/{category}', 'CategoryController@show');
        });

        Route::resource('products', 'ProductController');
        Route::group(['prefix' => 'products'], function () {
        });

        Route::resource('orders', 'OrderController');
        Route::group(['prefix' => 'orders'], function () {
        });

            Route::post('logout', 'AuthController@logout');
    });
});
