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

Route::post('/signup', 'Api\AuthController@signUp');
Route::post('/login', 'Api\AuthController@login');
Route::post('/forgot-password', 'Api\AuthController@forgotPass');
Route::post('/reset-password', 'Api\AuthController@changePassword');
Route::get('/logout', 'Api\AuthController@logout');


/*
|--------------------------------------------------------------------------
| HOSTEL Routes
|--------------------------------------------------------------------------
| Here is where register new hostels routes have been define.
|
*/

Route::post('/create-hostel', 'Api\HostelController@create');
Route::get('/list-hostels', 'Api\HostelController@listHostels');
Route::post('/view-hostel', 'Api\HostelController@hostelDetails');
Route::post('/delete-hostel', 'Api\HostelController@delete');
Route::post('/update-request', 'Api\HostelController@updateRequest');



/*
|--------------------------------------------------------------------------
| STUDENTS/USERS Routes
|--------------------------------------------------------------------------
| Here is where register new students/users routes have been define.
|
*/

Route::post('/create-student', 'Api\StudentController@create');
Route::get('/list-students', 'Api\StudentController@listStudents');
Route::post('/view-student', 'Api\StudentController@studentDetails');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN Routes
|--------------------------------------------------------------------------
| Here is where all super admin related routes have been define.
|
*/

Route::post('/approve-hostel', 'Api\SuperAdminController@approveHostel');
Route::post('/verify-hostel', 'Api\SuperAdminController@verifyHostel');
Route::post('/verify-user', 'Api\SuperAdminController@verifyUser');
Route::post('/update-hostel', 'Api\SuperAdminController@updateHostel');
// rejection requests
Route::post('/reject-update-hostel', 'Api\SuperAdminController@rejectUpdateHostel');
Route::post('/reject-hostel-approval', 'Api\SuperAdminController@rejectHostelApprovel');
Route::post('/reject-user-verification', 'Api\SuperAdminController@rejectUserVerification');
Route::post('/reject-hostel-verification', 'Api\SuperAdminController@rejectHostelVerification');



/*
|--------------------------------------------------------------------------
| HOSTEL SEARCHES Routes
|--------------------------------------------------------------------------
| Here is where all super admin related routes have been define.
|
*/

Route::post('/search-hostels','Api\SearchesController@searchHostels');



/*
|--------------------------------------------------------------------------
| HOSTEL IMAGES Routes
|--------------------------------------------------------------------------
| Here is where all super admin related routes have been define.
|
*/


Route::post('/create-image','Api\ImagesController@createImage');


/*
|--------------------------------------------------------------------------
| USER PROFILE IMAGES Routes
|--------------------------------------------------------------------------
| User profile images routes have been define here.
|
*/

Route::post('/create-profile-image','Api\ProfileImagesController@createImage');
