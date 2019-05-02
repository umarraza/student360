<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	//markAttendence(12,16,"2019-03-30 19:57:18","CheckIn");
	parentSignupAgain(85,16);
        return "yes";
    return view('Mails2.instituteSignup');
});
