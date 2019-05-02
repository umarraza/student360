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
// -----------------------  Routes Without Token ---------------------------- //

// Forgot Password
Route::post('/forgot-password', 'Api\PasswordController@forgotPassword');

// Reset Password
Route::post('/reset-password', 'Api\PasswordController@resetPassword');

// Login
Route::post('/login', 'Api\AuthController@login');

// Institute SignUp
Route::post('/institute-signup', 'Api\AdminController@instituteSignup');

// List of roles
Route::get('/list-roles', 'Api\AuthController@listRoles');

// List Packages.
Route::get('/list-packages', 'Api\PackageController@listPackages');
// Get Package Detail.
Route::post('/package-detail', 'Api\PackageController@packageDetail');

Route::group(['middleware' => 'jwt.auth'], function () 
{
	// Logout
	Route::get('/logout', 'Api\AuthController@logout');
	
	// Splash Login
	Route::get('/splash-login', 'Api\AuthController@splashLogin');
	
	// Update Device
	Route::post('/update-user-device', 'Api\AuthController@updateUserDevice');


	// -------------------------------- Student Routes ---------------------------- //
	// Add Student
	Route::post('/add-student', 'Api\StudentController@addStudent');

	// List All Students of Institute
	Route::post('/list-all-students-of-institute', 'Api\StudentController@listAllStudentsOfInstitute');

	// View All Studens of a parent in institute
	Route::post('/list-parent-students-of-institute', 'Api\StudentController@listParentStudentsOfInstitute');

	// Deactivate Student
	Route::post('/deactivate-student', 'Api\StudentController@deleteStudent');

	// Reactivate Student
	Route::post('/reactivate-student', 'Api\StudentController@reactiveStudent');

	// Single Student Detail
	Route::post('/student-detail', 'Api\StudentController@studentDetail');

	// Single Student Detail
	Route::post('/student-update-info', 'Api\StudentController@updateStudentInfo');

	// Student update image
	Route::post('/student-update-image', 'Api\StudentController@updateStudentImage');

	// -------------------------------- Mail Routes ---------------------------- //

	// Mail Single Institute
	Route::post('/mail-single-institute', 'Api\EmailController@mailSingleInstitute');

	// Mail Multiple Institute
	Route::post('/mail-multiple-institutes', 'Api\EmailController@mailMultipleInstitutes');

	// Mail Single Student Parent
	Route::post('/mail-single-student-parent', 'Api\EmailController@mailSingleParent');

	// Mail Multiple Institute
	Route::post('/mail-multiple-students-parent', 'Api\EmailController@mailMultipleParents');


	// -------------------------------- Attendence Routes ---------------------------- //

	// Mail Single Institute
	Route::post('/mark-attendence-checkin', 'Api\AttendenceController@markAttendenceCheckin');

	// Mail Multiple Institute
	Route::post('/mark-attendence-checkout', 'Api\AttendenceController@markAttendenceCheckout');

	// Mail Single Student Parent
	Route::post('/list-month-attendence-of-student', 'Api\AttendenceController@getMonthAttendenceOfStudent');

	// Mail Multiple Institute
	Route::post('/list-daily-attendence-of-students', 'Api\AttendenceController@getDailyAttendenceOfStudents');




	// -------------------------------- Institutes Routes ---------------------------- //


	// Get Parent Institues
	Route::get('/list-my-institutes', 'Api\AdminController@listMyInstitutes');

	// Get All Institues
	Route::get('/list-institutes', 'Api\AdminController@listAllInstitutes');

	// Update Institute Details
	Route::post('/update-institute-details', 'Api\AdminController@updateInstituteDetails');

	// Get Institute Details
	Route::post('/get-institute-details', 'Api\AdminController@getInstituteDetails');

	// Update Institute Image
	Route::post('/update-institute-image', 'Api\AdminController@updateInstituteImage');

	// -------------------------------- Admin Routes ---------------------------- //

	// Update Admins Details
	Route::post('/update-admin-details', 'Api\AdminController@updateAdminDetails');

	// Add secondary admins
	Route::post('/add-secondary-admin', 'Api\AdminController@addSecondaryAdmin');

	// Update secondary admins
	Route::post('/update-secondary-admin', 'Api\AdminController@updateSecondaryAdmin');

	// List secondary admins
	Route::post('/list-secondary-admins', 'Api\AdminController@listSecondaryAdmins');

	// Deactivate secondary admins
	Route::post('/deactivate-secondary-admins', 'Api\AdminController@deleteSecondaryAdmin');

	// Reactivate secondary admins
	Route::post('/reactivate-secondary-admins', 'Api\AdminController@reactiveSecondaryAdmin');


	// -------------------------------- Trainer Routes ---------------------------- //

	// Add Trainer
	Route::post('/add-trainer', 'Api\TrainerController@addTrainer');

	// Update Trainer Info
	Route::post('/update-trainer', 'Api\TrainerController@updateTrainer');

	// Update Trainer Info By Admin
	Route::post('/update-trainer-by-admin', 'Api\TrainerController@updateTrainerAdmin');

	// View All Trainers
	Route::post('/list-all-trainers-of-institute', 'Api\TrainerController@listAllTrainersOfInstitute');

	// View All Trainers
	Route::post('/get-trainer-detail', 'Api\TrainerController@getTrainerDetail');

	// Deactivate Trainer
	Route::post('/deactivate-trainer', 'Api\TrainerController@deleteTrainer');

	// Reactivate Trainer
	Route::post('/reactivate-trainer', 'Api\TrainerController@reactiveTrainer');



	// -------------------------------- Image Routes ---------------------------- //
	
	// Update Profile Image
	Route::post('/update-profile-image', 'Api\ImageController@updateProfileImage');
	// Delete Profile Image
	Route::get('/remove-profile-image', 'Api\ImageController@removeProfileImage');

	// -------------------------------- Payments Routes ---------------------------- //
	
	// List all payments
	Route::get('/all-payments', 'Api\PaymentHistoryController@listAllPayments');
	// List payments of single institute
	Route::post('/single-institute-payment', 'Api\PaymentHistoryController@listSpecificInstitutePaymentHistory');


	// -------------------------------- Event Routes ---------------------------- //
	
	// Add Event
	Route::post('/add-event', 'Api\EventController@addEvent');
	// Update Event
	Route::post('/update-event', 'Api\EventController@updateEvent');
	// View Event
	Route::post('/view-event', 'Api\EventController@viewEventDetail');
	// List Events
	Route::post('/list-events-of-institute', 'Api\EventController@allEventsOfInstitute');
	// Delete Event
	Route::post('/delete-event', 'Api\EventController@deleteEvent');


	// -------------------------------- Password Routes ---------------------------- //
	
	// Change Password Normally.
	Route::post('/change-password', 'Api\PasswordController@changePassword');
	// Change Password At first time login for trainer and secondary admin.
	Route::post('/change-password-sign-up-other', 'Api\PasswordController@changePasswordSignupTS');
	// Change Password At first time login for parent.
	Route::post('/change-password-sign-up-parent', 'Api\PasswordController@changePasswordSignupP');



	// -------------------------------- Package Routes ---------------------------- //

	// Upgrade Package.
	Route::post('/upgrade-package', 'Api\PackageController@upgradePackage');
	// Update Package.
	Route::post('/update-package', 'Api\PackageController@updatePackage');
	


	// ----------------------------------- Secrets ------------------------------------------//

    Route::post('/update-secrets','Api\AuthController@updateSecrets');
    Route::get('/get-secrets','Api\AuthController@getSecrets');


    Route::post('/update-secrets-super-admin','Api\AuthController@superAdminUpdateSecret');
    Route::get('/get-secrets-super-admin','Api\AuthController@superAdminGetSecret');
		
});