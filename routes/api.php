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
| register new hostels routes have been define.
|
*/

Route::post('/create-hostel', 'Api\HostelController@create');
Route::post('/delete-hostel', 'Api\HostelController@delete');
Route::get('/list-hostels', 'Api\HostelController@listHostels');
Route::post('/view-hostel', 'Api\HostelController@hostelDetails');
Route::get('/view-registered-hostels', 'Api\HostelController@registeredHostels');
Route::post('/hostel-available', 'Api\HostelController@updateAvailbility');

/*
|--------------------------------------------------------------------------
| STUDENTS/USERS Routes
|--------------------------------------------------------------------------
| register new students/users routes have been define.
|
*/

Route::post('/create-student', 'Api\StudentController@create');
Route::get('/list-students', 'Api\StudentController@listStudents');
Route::post('/student-details', 'Api\StudentController@studentDetails');
Route::post('/update-student', 'Api\StudentController@updateStudent');

/*
|--------------------------------------------------------------------------
| SUPER ADMIN Routes
|--------------------------------------------------------------------------
| all super admin related routes have been define.
|
*/

Route::post('/verify-user', 'Api\SuperAdminController@verifyUser');
Route::post('/verify-hostel', 'Api\SuperAdminController@verifyHostel');
Route::post('/approve-hostel', 'Api\SuperAdminController@approveHostel');
Route::get('/list-approval-requests', 'Api\SuperAdminController@listapprovalRequests');
Route::post('/approve-update-request', 'Api\SuperAdminController@approveUpdateRequest');
Route::get('/update-hostel-requests', 'Api\SuperAdminController@listHostelsUpdateRequests');
Route::get('/verify-hostel-requests', 'Api\SuperAdminController@listHostelsVerifyRequests');

// rejection requests
Route::post('/reject-hostel-approval', 'Api\SuperAdminController@rejectHostelApprovel');
Route::post('/reject-user-verification', 'Api\SuperAdminController@rejectUserVerification');
Route::post('/reject-hostel-verification', 'Api\SuperAdminController@rejectHostelVerification');

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
Route::post('/update-review','Api\ReviewsController@updateReview');
Route::post('/delete-review','Api\ReviewsController@deleteReview');

/*
|--------------------------------------------------------------------------
| Mess Menu Routes
|--------------------------------------------------------------------------
| All Mess Menu related routes have been defined here.
|
*/

Route::post('/update-mess-menu', 'Api\MessMenuController@updateMessMenu');
Route::post('/list-mess-menu', 'Api\MessMenuController@listMessMenu');

/*
|--------------------------------------------------------------------------
| HOSTEL SEARCHES Routes
|--------------------------------------------------------------------------
| all super admin related routes have been define.
|
*/

Route::post('/search-hostels','Api\SearchesController@searchHostels');
Route::post('/search-by-prices','Api\SearchesController@searchByPrices');
Route::post('/search-by-features','Api\SearchesController@searchByFeatures');

/*
|--------------------------------------------------------------------------
| HOSTEL IMAGES Routes
|--------------------------------------------------------------------------
| all Hostel Images routes have been define.
|
*/

Route::post('/create-image','Api\ImagesController@createImage');
Route::get('/list-image','Api\ImagesController@listImages');

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
| Queries Routes
|--------------------------------------------------------------------------
| All Queries routes have been defined here.
|
*/

Route::post('/create-query', 'Api\QueriesController@create');
Route::post('/delete-query', 'Api\QueriesController@delete');

/*
|--------------------------------------------------------------------------
| Threads Routes
|--------------------------------------------------------------------------
| All Threads routes have been defined here.
|
*/

Route::get('/list-threads','Api\ThreadsController@listThreads');
Route::post('/approve-hostel-request', 'Api\RequestsController@create');

/*
|--------------------------------------------------------------------------
| REQUESTS Routes
|--------------------------------------------------------------------------
| All requests routes to super admin i.e request to approve, verify and 
| update hostel have been define here.
*/
Route::post('/update-hostel-request', 'Api\RequestsController@updateHostelRequest');

Route::post('/create-rating', 'Api\RatingsController@store');
