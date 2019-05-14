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
    return view('welcome');
});

/**
 *   In availability, user can update rooms and beds, whether how many of them are available.   What does it mean by availibilty?
 *   Threadid to show in result set of queries?
 * 
 */