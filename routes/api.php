<?php

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;

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


Route::group(['middleware' => ['api','jsonify']], function ($router) {
    // book-classes/910
    Route::group(['prefix'=>"{role}"], function(){
        Route::post('login', 'AuthController@login');
        Route::post('refresh', 'AuthController@refresh');

        Route::group(['middleware'=>'jwtchecker'], function(){
            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
        });

    });

    Route::group(['middleware'=>'jwtchecker'], function(){
        Route::get('student/balance', "UserController@getBalance");
        Route::get('student/schedule', "UserController@getClassSchedule");
        Route::get('student/language', 'UserController@getLanguage');
        Route::get('student/dashboard', 'UserController@studentDashboard');
        Route::post('student/avatar', 'UserController@uploadAvatar');
        Route::post('student/profile', 'UserController@storeProfile');

        Route::get('language/{lang?}', 'UserController@getLanguage');
    
        Route::get('available/search/{start_datetime?}', 'AvailabilityController@searchAvailable');
        Route::get('available/teacher/{id}', 'AvailabilityController@getAvailableTeacher');
        Route::post('available/book', 'AvailabilityController@bookAvailableSchedule');
    
        Route::get('school/packages', 'SchoolPackageController@index');
    
        Route::post('orders', 'OrderController@store');
        Route::get('orders', 'OrderController@index');

    });
});


