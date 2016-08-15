<?php

namespace App\Http\Controllers\Auth;

use App\Student;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;                                                            // to authenticate the user for login
class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    protected $redirectAfterLogout = '/';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['except' => 'logout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'usn' => 'required|max:10|unique:students',
            'phone' => 'required|min:10|max:20|unique:students',
            'address' => 'required|max:255',
            'semester' => 'required',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return Student::create([
            'usn' => $data['usn'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'semester' => $data['semester'],
            'phone' =>$data['phone'],
            'address' => $data['address'],
        ]);
    }

    /**
     * user login.
     *
     * @param  array  $data
     * @return User
     */

    public function authenticate(array $data)
    {
        if (Auth::attempt(['usn' => $data['usn'], 'password' => $data['password']], $remember))
        {
            // Authentication passed...
            return redirect('/profile');//->intended('dashboard');
        }
        else
        {
            return redirect('/login')
                      ->withInput();
        }
    }

    // to login the user into the system
    public function doLogin(Request $request)
    {
      // Validate the request...
      echo "doLogin";
      $validator = Validator::make($request->all(), [
              'usn' => 'required',
              'password' => 'required|min:6'
          ]);
          // if validation fails send back to login page
          if ($validator->fails())
          {
              echo "fail";
              //return redirect('/login')
                        //  ->withErrors($validator)
                      //    ->withInput(Input::except('password'));
          }
      //do login
      $user = Student::where('usn', $request->usn);
      echo "$user->password";

      if (Auth::attempt(['usn' => $request->usn, 'password' => $request->password], $remember))
      {
          //$value = $request->session()->put('id',$user->id);
          echo "logged in";

          $user = Student::where('usn', $request->usn)->get();
          echo $user->id;

          session(['key' => $user->id]);

          //return redirect('/profile');
      }
      else
      {
          echo "failed";
        //  return redirect('/login')
        //                ->withErrors($user)
        //                ->withInput();
      }
    }

}
