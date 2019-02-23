<?php

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => ['api']], function ($router) {

    Route::get('test', function(){

    });

    Route::group(['prefix' => 'auth'], function(){
        Route::post('login', 'AuthController@login');
        Route::post('refresh', 'AuthController@refresh');

        Route::group(['middleware'=>'jwtchecker'], function(){
            Route::post('logout', 'AuthController@logout');
            Route::get('me', 'AuthController@me');
        });

    });




    // OLD STUDENT LOGIN
    Route::group(['middleware'=>'jwtchecker'], function() {
        // create organization
        Route::post('entities', 'EntityController@store');
        Route::put('entities/{id}', 'EntityController@update');
        Route::get('entities', 'EntityController@index');
        Route::get('entities/{id}', 'EntityController@show');
        Route::post('entities/assign', 'EntityController@assign');

        // get class types
        Route::get('class-types', 'ClassTypeController@index');

        // base packages
        Route::post('base-packages', 'BasePackageController@store');
        Route::put('base-packages/{id}', 'BasePackageController@update');
        Route::get('base-packages', 'BasePackageController@index');
        Route::get('base-packages/{id}', 'BasePackageController@show');
        Route::get('provider/base-packages', 'BasePackageController@providerIndex');

        // base penalties
        Route::post('base-penalties', 'BasePenaltyController@store');
        Route::put('base-penalties/{id}', 'BasePenaltyController@update');
        Route::get('base-penalties', 'BasePenaltyController@index');
        Route::get('base-penalties/{id}', 'BasePenaltyController@show');

        // base rates
        Route::post('base-rates', 'BaseRateController@store');
        Route::put('base-rates/{id}', 'BaseRateController@update');
        Route::get('base-rates', 'BaseRateController@index');
        Route::get('base-rates/{id}', 'BaseRateController@show');

        // base teacher rates
        Route::post('base-teacher-rates', 'BaseTeacherRateController@store');
        Route::put('base-teacher-rates/{id}', 'BaseTeacherRateController@update');
        Route::get('base-teacher-rates', 'BaseTeacherRateController@index');
        Route::get('base-teacher-rates/{id}', 'BaseTeacherRateController@show');

        // student account types
        Route::get('student-account-types', 'StudentAccountTypeController@index');

        // students
        Route::post('students', 'StudentController@store');
        Route::put('students/{id}', 'StudentController@update');
        Route::get('students/{id}', 'StudentController@show');
        Route::get('students', 'StudentController@index');

        // teacher account types
        Route::get('teacher-account-types', 'TeacherAccountTypeController@index');

        // teachers
        Route::post('teachers', 'TeacherController@store');
        Route::put('teachers/{id}', 'TeacherController@update');
        Route::get('teachers/{id}', 'TeacherController@show');
        Route::get('teachers', 'TeacherController@index');

        // entity packages
        Route::post('entity-packages', 'EntityPackageController@store');
        Route::put('entity-packages/{id}', 'EntityPackageController@update');
        Route::delete('entity-packages/{id}', 'EntityPackageController@destroy');
        Route::get('entity-packages/{id}', 'EntityPackageController@show');
        Route::get('entity-packages', 'EntityPackageController@index');
        Route::get('provider/entity-packages', 'EntityPackageController@providerIndex');

        // schedules
        Route::post('schedules', 'ScheduleController@store');
        Route::put('schedules/{id}', 'ScheduleController@update');
        Route::delete('schedules/{id}', 'ScheduleController@destroy');
        Route::get('schedules/{id}', 'ScheduleController@show');
        Route::get('schedules', 'ScheduleController@index');
        Route::get('schedules/{id}/students', 'ScheduleController@students');


        // mark teacher as absent
        Route::put('schedules/{id}/absent', 'ScheduleController@absent');
        // mark student as absent
        Route::post('schedules/{id}/absent', 'ScheduleBookingController@absent');

        // book a schedule
        Route::post('schedule-bookings', 'ScheduleBookingController@store');


        // uploading an asset for the class
        Route::post('schedule-assets/{id?}', 'ScheduleAssetController@store');
        Route::get('schedule-assets', 'ScheduleAssetController@index');
        Route::get('schedule-assets/{id}', 'ScheduleAssetController@show');
        Route::get('schedules/{id}/assets', 'ScheduleAssetController@show');

        // make a class remark after a class
        Route::post('students/{student_id}/remarks', 'StudentRemarkController@store');

        // Subject Teacher Rate
        Route::post('subject-teacher-rates', 'SubjectTeacherRateController@store');
        Route::put('subject-teacher-rates/{id}', 'SubjectTeacherRateController@update');
        Route::get('subject-teacher-rates', 'SubjectTeacherRateController@index');
        Route::get('subject-teacher-rates/{id}', 'SubjectTeacherRateController@show');
        // Route::delete('subject-teacher-rates', 'SubjectTeacherRateController@destroy');



        // schedule teacher rates
        Route::post('schedule-teacher-rates', 'SubjectTeacherRateController@store');
        Route::put('schedule-teacher-rates/{id}', 'SubjectTeacherRateController@update');
        Route::get('schedule-teacher-rates', 'SubjectTeacherRateController@index');
        Route::get('schedule-teacher-rates/{id}', 'SubjectTeacherRateController@show');
 

        Route::get('search/schedules/{datetime?}', 'ScheduleController@availableTeachers');
        Route::get('search/teacher/{id}/schedules/{datetime?}', 'ScheduleController@availableTeacherSchedule');

        // orders
        Route::post('orders', 'OrderController@store');
        Route::put('orders/{id}/approve', 'OrderController@approve');
        Route::get('orders', 'OrderController@index');

        // balances
        Route::get('balances', 'BalanceController@index');




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


    });
});
