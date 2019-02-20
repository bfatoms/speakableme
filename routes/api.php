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

        $data['students'][] = [
            'id' => "091823-uasoid9834-34234",
            'absence_reason' => 'na tae'
        ];
        $data['students'][] = [
            'id' => "4567890-asd9a8sd8t3e",
            'absence_reason' => 'na ihi'
        ];

        return json_encode($data);
        $starts_at = Carbon::parse('2019-02-20 12:00:00');

        $now = now();

        // not use else if
        if($starts_at->diffInHours($now) > 8)
        {
            $penalty = config('speakable.penalty1');
            $note .= "\nIncurred penalty 2 for cancelling a schedule.";
        }

        if($starts_at->diffInHours($now) < 4)
        {
            $penalty = config('speakable.penalty2');
            $note = "\nIncurred penalty 2 for cancelling a schedule.";
        }

        if($starts_at->diffInHours($now) < 2)
        {
            $penalty = config('speakable.penalty3');
            $note = "\nIncurred penalty 3 for cancelling a schedule.";
        }



        return $penalty;

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
    Route::group(['middleware'=>'jwtchecker'], function(){
        // create organization
        Route::post('entities', 'EntityController@store');
        Route::put('entities/{id}', 'EntityController@update');
        Route::get('entities', 'EntityController@index');
        Route::get('entities/{id}', 'EntityController@show');

        // get class types
        Route::get('class-types', 'ClassTypeController@index');

        // base packages
        Route::post('base-packages', 'BasePackageController@store');
        Route::put('base-packages/{id}', 'BasePackageController@update');
        Route::get('base-packages', 'BasePackageController@index');
        Route::get('base-packages/{id}', 'BasePackageController@show');

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

        // schedules
        Route::post('schedules', 'ScheduleController@store');
        Route::put('schedules/{id}', 'ScheduleController@update');
        Route::delete('schedules/{id}', 'ScheduleController@destroy');
        Route::get('schedules/{id}', 'ScheduleController@show');
        Route::get('schedules', 'ScheduleController@index');

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
