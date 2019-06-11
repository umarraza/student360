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
Route::post('/login2', 'Api\AuthController@login2');
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

Route::post('/create-hostel', 'Api\HostelController@createHostel');
Route::post('/delete-hostel', 'Api\HostelController@deleteHostel');
Route::get('/list-hostels', 'Api\HostelController@listHostels');
Route::post('/view-hostel', 'Api\HostelController@hostelDetails');
Route::post('/hostel-details', 'Api\HostelController@hostelDetails2');
Route::get('/all-hostels', 'Api\HostelController@allHostels'); // for registered / non-registered users
Route::get('/all-hostels2', 'Api\HostelController@allHostels2'); // for registered / non-registered users

Route::post('/hostel-available', 'Api\HostelController@updateAvailbility');
Route::get('/view-registered-hostels', 'Api\HostelController@listRegisteredHostels');

/*
|--------------------------------------------------------------------------
| STUDENTS/USERS Routes
|--------------------------------------------------------------------------
| register new students/users routes have been define.
|
*/

Route::post('/create-student', 'Api\StudentController@createStudent');
Route::get('/list-students', 'Api\StudentController@listStudents');
Route::post('/student-details', 'Api\StudentController@studentDetails');
Route::post('/update-student', 'Api\StudentController@updateStudent');
Route::post('/update-student2', 'Api\StudentController@updateStudent2');

Route::get('/view-registered-students', 'Api\StudentController@listRegisteredStudents');

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
Route::post('/reject-hostel-update-request', 'Api\SuperAdminController@rejectUpdateHostel');


/*
|--------------------------------------------------------------------------
| Reviews Routes
|--------------------------------------------------------------------------
| All review related routes have been defined here.
|
*/

Route::post('/create-review','Api\ReviewsController@create');
Route::get('/list-reviews','Api\ReviewsController@listReviews');
Route::post('/list-hostel-reviews','Api\ReviewsController@listHostelReviews');
Route::post('/list-hostel-reviews2','Api\ReviewsController@listHostelReviews2');

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
Route::post('/update-mess-menu-time', 'Api\MessMenuController@updateMessMenuTimePrice');
Route::post('/show-mess-menu', 'Api\MessMenuController@showMessMenu');

/*
|--------------------------------------------------------------------------
| HOSTEL SEARCHES Routes
|--------------------------------------------------------------------------
| all super admin related routes have been define.
|
*/

Route::post('/search-hostels','Api\SearchesController@searchHostels');
Route::post('/search-by-features','Api\SearchesController@searchByFeatures');

/*
|--------------------------------------------------------------------------
| HOSTEL IMAGES Routes
|--------------------------------------------------------------------------
| all Hostel Images routes have been define.
|
*/

Route::post('/list-images','Api\ImagesController@listImages');
Route::post('/create-hostel-image','Api\ImagesController@createHostelImages');
Route::post('/update-hostel-images','Api\ImagesController@updateHostelImage');

/*
|--------------------------------------------------------------------------
| USER PROFILE IMAGES Routes
|--------------------------------------------------------------------------
| User profile images routes have been define here.
|
*/

Route::post('/create-profile-image','Api\ProfileImagesController@createImage');
Route::post('/update-profile-image','Api\ProfileImagesController@updateProfileImage');


/*
|--------------------------------------------------------------------------
| Queries Routes
|--------------------------------------------------------------------------
| All Queries routes have been defined here.
|
*/

Route::post('/create-query', 'Api\QueriesController@createQuery');
Route::post('/delete-query', 'Api\QueriesController@delete');
Route::post('/list-queries','Api\QueriesController@listQueries');


/*
|--------------------------------------------------------------------------
| Threads Routes
|--------------------------------------------------------------------------
| All Threads routes have been defined here.
|
*/
Route::post('/create-thread','Api\ThreadsController@createThread');
Route::get('/list-threads','Api\ThreadsController@listThreads');
Route::post('/list-student-threads','Api\ThreadsController@listStudentThreads');

/*
|--------------------------------------------------------------------------
| REQUESTS Routes
|--------------------------------------------------------------------------
| All requests routes to super admin i.e request to approve, verify and 
| update hostel have been define here.
*/

Route::post('/update-hostel', 'Api\RequestsController@updateHostelRequest');
Route::post('/send-approve-hostel-request', 'Api\RequestsController@approveHostelRequest');

Route::post('/create-rating', 'Api\RatingsController@createRating');
Route::post('/create-rating2', 'Api\RatingsController@createRating2');



/*
|--------------------------------------------------------------------------
| Features Routes
|--------------------------------------------------------------------------
| 
*/

Route::post('/create-feature', 'Api\FeaturesController@createFeature');
Route::get('/list-features', 'Api\FeaturesController@listFeature');
Route::post('/delete-features', 'Api\FeaturesController@deleteFeature');



