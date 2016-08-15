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

use App\Http\Controllers\View;          // to acess the views functions

class StudentController extends Controller
{
  // adding new student
  public function AddNewStudent(Request $request)
  {
  // Validate the request...
  $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'usn' => 'required|max:10|unique:students',
            'phone' => 'required|min:10|max:20|unique:students',
            'address' => 'required|max:255',
            'semester' => 'required',
      ]);
      // if validation fails send back to register page
      if ($validator->fails()) {
          return redirect('/register')
                      ->withErrors($validator)
                      ->withInput();
      }
  // storing the data
  $user = new Student;
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
      return redirect('/dashboard');
  }
  return redirect('/student/login');
  }


  // to login the user into the system
  public function doLogin(Request $request)
  {
    // Validate the request...
    echo "in doLogin";
    $validator = Validator::make($request->all(), [
            'usn' => 'required',
            'password' => 'required|min:6'
        ]);
        // if validation fails send back to login page
        if ($validator->fails())
        {
            return redirect('/student/login')
                       ->withErrors($validator)
                       ->withInput();
        }
    //do login
    $user = Student::where('usn', $request->usn);
    if (Auth::attempt(['usn' => $request->usn, 'password' => $request->password]))
    {
        //$value = $request->session()->put('id',$user->id);
        echo "logged in";
        $user = Student::where('usn', $request->usn)->get();
        return redirect('/dashboard');
    }
    else
    {
        //echo "failed";
        return redirect('/student/login')
                      ->withErrors($request)
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
  public function ShowProfile(Request $request)
  {
    $user = Auth::user();
    return view('profile',['user'=>$user]);
  //
  }

  // function to edit the profile of the Student
  public function EditProfile(Request $request)
  {
    $user = Auth::user();
    return view('profile',['user'=>$user]);
  }

  public function EditProfileAddData(Request $request)
  {
  // Validate the request...
  $validator = Validator::make($request->all(), [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255',
          'usn' => 'required|max:10',
          'phone' => 'required|min:10|max:20',
          'address' => 'required|max:255',
      ]);
      // if validation fails send back to register page
      if ($validator->fails()) {
          return redirect('/edit/profile')
                      ->withErrors($validator)
                      ->withInput();
      }
  // getting logged in user id to update its data
  $user = Auth::user();
  //saving the data into table
  DB::table('students')
            ->where('id',$user->id)
            ->update(['usn'=>$request->usn,'name'=>$request->name,'email'=>$request->email,'semester'=>$request->semester,'phone'=>$request->phone,'address'=>$request->address]);
  return redirect('/dashboard');
  }

}
