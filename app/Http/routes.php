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
Route::get('/login', function(){
    return view('login');
});
Route::post('/login', 'StudentController@doLogin' );

// to register the user
Route::get('/register', function(){
    return view('register');
});
Route::post('/register', 'StudentController@AddNewStudent' );

// to logout
Route::auth();
Route::get('/logout', 'StudentController@Logout' );
