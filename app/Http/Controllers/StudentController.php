<?php

namespace App\Http\Controllers;

use App\Student;                        // to use the user class

use Validator;                          // to use the Validator functions to validate the user input

use Illuminate\Http\Request;
                                        // to use the request function
use App\Http\Requests;

use Illuminate\Support\Facades\Auth;    // to use predefined auth process

use App\Http\Controllers\Controller;    // to use the Controller class

use DB;                                 // to acess to the database

class StudentController extends Controller
{
  // adding new student
  public function AddNewStudent(Request $request)
  {
  // Validate the request...
  $validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:students',
          'password' => 'required|min:6|confirmed',
          'usn' => 'required|max:10|unique:students',
          'phone' => 'required|min:10|max:20|unique:students'
          'address' => 'required|max:255',
      ]);
      // if validation fails send back to register page
      if ($validator->fails()) {
          return redirect('/register')
                      ->withErrors($validator)
                      ->withInput();
      }
  // storing the data
  $user = new Students;

  // getting the users data
  $user->name = $request->name;
  $user->usn = $request->usn;
  $user->email = $request->email;
  $user->password = bcrypt($request->password);
  $user->phone = $request->phone;
  $user->semester = $request->semester;
  $user->address = $request->address;

  //saving the data into table
  $user->save();
  if($user->save())
    {
      echo "data added to table";
    }

  //return redirect('/profile');
  }

  // to login the user into the system
  public function doLogin(Request $request)
  {
    // Validate the request...
    $validator = Validator::make($request->all(), [
            'usn' => 'required',
            'password' => 'required|min:6'
        ]);
        // if validation fails send back to login page
        if ($validator->fails()) {
            return redirect('/login')
                        ->withErrors($validator)
                        ->withInput();
        }
    //do login
    $user = Student::where('usn', $request->usn);
    //echo "$user->password";

    if (Auth::attempt(['usn' => $request->usn, 'password' => $request->password]))
    {
        //$value = $request->session()->put('id',$user->id);
        echo "logged in";

        $user = Student::where('usn', $request->usn)->get();
        echo $user->id;

        session(['key' => $user->id]);

        return redirect('/profile');
    }
    else
    {
        //echo "failed";
        return redirect('/login')
                      ->withErrors($user)
                      ->withInput();
    }

  }

  // function to logout
  public function Logout()
  {
      Auth::logout();
      //Session::flush(); //clears out all the exisiting sessions
      return redirect('/login');
  }

  // function to show the profile of the Student
  public function showProfile(Request $request)
  {
    $value = session('key');
    //echo "$value";
    $user = Student::where('id', session('key'));
    return view('about',['user'=>$user]);
  //
  }
