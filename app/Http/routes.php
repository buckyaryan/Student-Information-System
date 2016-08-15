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
    if(Auth::check())
    {
      return redirect('/dashboard');
    }
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
    return view('home');  //temporary dashboard
});

Route::get('/add/marks/{$term}', function($term){
  //$term=['1'=>'1st internal','2'=>'2nd internal','3'=>'3rd internal','4'=>'term end exam']
  switch ($term)
  {
    case '1': return view();
    case '2': return view();
    case '3': return view();
    case '4': return view();
    case 'profile': return view();
  }
});

Route::get('edit/profile','StudentController@EditProfile');
Route::post('edit/profile','StudentController@EditProfileAddData');
