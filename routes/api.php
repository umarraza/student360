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

Route::post('/login', 'Api\AuthController@login');
Route::get('/logout', 'Api\AuthController@logout');
Route::post('/signup', 'Api\AuthController@signUp');
Route::post('/forgot-password', 'Api\AuthController@forgotPass');
Route::post('/reset-password', 'Api\AuthController@changePassword');


/*
|--------------------------------------------------------------------------
| HOSTEL Routes
|--------------------------------------------------------------------------
| Here is where register new hostels routes have been define.
|
*/

Route::post('/create-hostel', 'Api\HostelController@create');
Route::post('/delete-hostel', 'Api\HostelController@delete');
Route::get('/list-hostels', 'Api\HostelController@listHostels');
Route::post('/view-hostel', 'Api\HostelController@hostelDetails');
Route::get('/view-registered-hostels', 'Api\HostelController@registeredHostels');
Route::post('/hostel-available', 'Api\HostelController@updateAvailbility');
Route::post('/update-hostel-request', 'Api\HostelController@updateHostelRequest');




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
Route::post('/update-student', 'Api\StudentController@updateStudent');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN Routes
|--------------------------------------------------------------------------
| Here is where all super admin related routes have been define.
|
*/
Route::post('/verify-user', 'Api\SuperAdminController@verifyUser');
Route::post('/verify-hostel', 'Api\SuperAdminController@verifyHostel');
Route::post('/approve-hostel', 'Api\SuperAdminController@approveHostel');
Route::get('/update-hostel-requests', 'Api\SuperAdminController@listHostelsUpdates');
Route::post('/approve-update-request', 'Api\SuperAdminController@approveUpdateRequest');

// rejection requests
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


/*
|--------------------------------------------------------------------------
| Reviews Routes
|--------------------------------------------------------------------------
| All review related routes have been defined here.
|
*/

Route::post('/create-review','Api\ReviewsController@create');
Route::get('/list-reviews','Api\ReviewsController@listReviews');
Route::get('/list-hostel-reviews','Api\ReviewsController@listHostelReviews');


/*
|--------------------------------------------------------------------------
| Mess Menu Routes
|--------------------------------------------------------------------------
| All Mess Menu related routes have been defined here.
|
*/

Route::post('/update-mess-menu', 'Api\MessMenuController@updateMessMenu');
Route::post('/list-mess-menu', 'Api\MessMenuController@listMessMenu');

