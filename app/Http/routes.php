<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});
// to login
Route::get('/student/login', function(){
    return view('studentlogin');
});
Route::post('/student/login', 'StudentController@doLogin' );

// to register the user
Route::get('/register', function(){
    return view('register');
});
Route::post('/register', 'StudentController@AddNewStudent' );

// to logout
Route::auth();
Route::get('/logout', 'StudentController@Logout' );

// to register the user
Route::auth();
Route::get('/dashboard', function(){
    return view('dashboard');
});
