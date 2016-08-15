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

class MarksController extends Controller
{
    public $sub_sem_1=array('14mat11','14phy12','14civ13','14eme14','14ele15','14wsl16','14phyl17','14cip18');
    // function to add the marks to the DB
    public function AddMarks(Request $request)
    {
      $sub=array('x14mat11','x14phy12','x14civ13','x14eme14','x14ele15','x14wsl16','x14phyl17','x14cip18');
      $validator = Validator::make($request->all(), [
                'x14mat11' =>'required',
                'x14phy12' =>'required',
                'x14civ13' =>'required',
                'x14eme14' =>'required',
                'x14ele15' =>'required',
                'x14wsl16' =>'required',
                'x14phyl17' =>'required',
                'x14cip18' =>'required',
          ]);
          // if validation fails send back to register page
          if ($validator->fails()) {
              return redirect('/add/marks/1')
                          ->withErrors($validator)
                          ->withInput();
          }
          $user=Auth::user();
          DB::table('marks_1_1')->insert([
            'sid'=>$user->id,
            'usn'=>$user->usn,
            '14mat11'=>$request->x14mat11,
            '14phy12'=>$request->x14phy12,
            '14civ13'=>$request->x14civ13,
            '14eme14'=>$request->x14eme14,
            '14ele15'=>$request->x14ele15,
            '14wsl16'=>$request->x14wsl16,
            '14phyl17'=>$request->x14phyl17,
            '14cip18'=>$request->x14cip18,
          ]);

          return Redirect('/dashboard');
    }

    // function to display the marks form
    public function DisplayMarksForm()
    {
        $user=Auth::user();
        $sub=array('x14mat11','x14phy12','x14civ13','x14eme14','x14ele15','x14wsl16','x14phyl17','x14cip18');
        return View('marks',['sub'=>$sub]);
    }

    public function DisplayMarks()
    {
        $user=Auth::user();
        $sub_sem_1=array('x14mat11','x14phy12','x14civ13','x14eme14','x14ele15','x14wsl16','x14phyl17','x14cip18');
        $marks_1_1=DB::table('marks_1_1')->where('sid', '=', $user->id)-first();
        return View('showmarks',['sub'=>$sub_sem_1,'marks_1_1'=>$marks_1_1]);
    }
}
