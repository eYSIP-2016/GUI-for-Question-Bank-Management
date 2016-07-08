<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use View;
use Input;
use Redirect;
use Illuminate\Http\Request;


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
    protected $redirectTo = '/';

    protected $redirectAfterLogout = '/login';
    

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['only' => [
            'login',
            'showLoginForm'
            
        ]]);
        
        $this->middleware('auth', ['except' => [
            'login',
            'showLoginForm'

        ]]);

        $this->middleware('adm', ['except' => [
            'login',
            'showLoginForm',
            'logout'
        ]]);
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
            'username' => 'required|max:64|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
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
        

        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        //return Auth::user();
    }

    public function postRegister(Request $request)
    {
    // Handle authorization
    $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create($request->all());
        return Redirect::route('users.index');
    } 



    protected function authenticated()
{
        if(Auth::user()->user_type_id == 1) {
            return redirect('home');
        }

        return redirect('questions');
 }


    protected function index() { 
        //$users = User::all(); 
        $users = User::where('user_type_id', '=', 0)->paginate(5);
        //$users = DB::table('users')->where('user_type_id', '=', 0)->get();
        //$users = User::paginate(2);
        return view('users.index', compact('users'));
        //return View::make('user.index', compact('users'));       //this also works just put "use View" on top
    }

    public function edit($id){


        $user = User::find($id);             //find a user from User model(extracted from db) with this id
        if (is_null($user)){                 //if not found return to same page
            return Redirect::route('users.index'); 
        } 
        return view('users.edit', compact('user')); 
    }

    public function update($id){            //method to update a user in user model
        $input = Input::all();              // input specifies the values from the web
        // $validation = Validator::make($input, User::$rules); 
        //if ($validation->passes()){ 
            $user = User::find($id);              // it finds the row with $id and stores it in the user variable
            $user->update($input);                // update the value stored in database with input values from user values
            return Redirect::route('users.index', $id); 
       // } 
        //return Redirect::route('users.edit', $id) ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }

    public function destroy($id) {        //it calls the method delete
        User::find($id)->delete();        //fine user with a value in id and delete it from user model
        return Redirect::route('users.index'); 
    } 


}
