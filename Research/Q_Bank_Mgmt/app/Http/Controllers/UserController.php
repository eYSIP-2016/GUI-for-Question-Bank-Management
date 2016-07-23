<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Input;
use Redirect;
use View;

class UserController extends Controller
{
    //

    public function index() { 
        //$users = User::all(); 
        $users = User::paginate(10);
        return view('users.index', compact('users'));
        //return View::make('user.index', compact('users'));       //this also works just put "use View" on top
    }


   public function doLogin()
    {
        $rules = array(
        'uname'    => 'required|min:3', // make sure the username is required and greater than 3
        'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 cha
        );
          

        




        //rums the validator on inputs
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
                return Redirect::to('login')
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      
        }  else {
                // create our user data for the authentication
                $webuserdata =
                 array(
                'username'     => Input::get('uname'),           //with label name = uname;
                'password'  => Input::get('password')
                );  
                
                //$webusername = $webuserdata['username'];
                //$webpassword = $webuserdata['password'];

                $dbuserdata = User::where('username', $webuserdata['username'] )->first();

               // $dbuserdata = User::find($webuserdata['username']);
            }
        // attempt to do the login
        if ( $webuserdata['password']==$dbuserdata['password']) {
        
            if (is_null($dbuserdata)){
                echo'fail';
                echo $webuserdata['username'];
                //echo $webuserdata;
                
            }
            else
            {
               //echo $dbuserdata['id'];
               //echo 'success';
               //return redirect()->route('authenticate',$dbuserdata);

                if( $dbuserdata['user_type_id'] == 1){
                   //return Redirect::to('authenticate',$dbuserdata['id']);
                    return view('users.admin', compact('dbuserdata'));
                }
                else{

                    return view('users.user', compact('dbuserdata')); 
                    //return Redirect::to('testhome');
                    //echo 'validation successful! but u are not admin .u are  anormal user';
                }
            }
        //echo $dbuserdata['password'];
        //echo 'validation successful!';
        // redirect them to the secure section or whatever
        
        // for now we'll just echo success (even though echoing in a controller is bad)
         
        }  else {        
        // validation not successful, send back to form 
        	//echo $ud['uname'];
        	//echo $webuserdata['password'];

            //echo $webuserdata['username'];
        	//echo $dbuserdata;
        return Redirect::to('welcomeGUI');

        }
    }

   /** public function authenticate($id){
        $dbuserdata = User::find($id);
        $var = 1;
        if( $dbuserdata['user_type_id'] == 1){                 //user type id belongs to type id == 1  i.e. it's admin
            //echo $dbuserdata('user_type_id');
         
            return view('users.admin', compact('dbuserdata'));
        echo $dbuserdata['user_type_id'];
        echo 'hey db0';
        }
        return view('users.user', compact('dbuserdata'));  
              
                                                           
                  
    }**/

    public function create(){
        return View::make('users.create');
    }


    public function store(){ 
        $input = Input::all(); 
        //$validation = Validator::make($input, User::$rules);  //User::rules -> calling rules var in User cllass
        //if ($validation->passes()) {
            User::create($input);                     //callin create method of model User equi to insert query in sql
            return Redirect::route('users.index');
        //}
        return Redirect::route('users.create') ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }


    public function edit($id){
        $user = User::find($id);             //find a user from User model(extracted from db) with this id
        if (is_null($user)){                 //if not found return to same page
            return Redirect::route('users.index'); 
        } 
        return View::make('users.edit', compact('user')); 
    }

    
    public function update($id){            //method to update a user in user model
        $input = Input::all();              // input specifies the values from the web
        $validation = Validator::make($input, User::$rules); 
        if ($validation->passes()){ 
            $user = User::find($id);              // it finds the row with $id and stores it in the user variable
            $user->update($input);                // update the value stored in database with input values from user values
            return Redirect::route('users.show', $id); 
        } 
        return Redirect::route('users.edit', $id) ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }

    public function destroy($id) {        //it calls the method delete
        User::find($id)->delete();        //fine user with a value in id and delete it from user model
        return Redirect::route('users.index'); 
    } 




}






//copied file

/**

this is my copied file
*

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;
use Input;
use Redirect;
use App\User;
use View;


use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
   
   // $users = User::all();      //To access the users table and storing it in $users
    //$users->toarray();

    

    public function index() { 
    	//$users = User::all(); 
    	$users = User::paginate(10);
    	return view('users.index', compact('users'));
    	//return View::make('user.index', compact('users'));       //this also works just put "use View" on top
    }

    public function create(){
    	return View::make('users.create');
    }


    public function store(){ 
    	$input = Input::all(); 
    	$validation = Validator::make($input, User::$rules);  //User::rules -> calling rules var in User cllass
    	if ($validation->passes()) {
    	    User::create($input);                     //callin create method of model User equi to insert query in sql
    		return Redirect::route('users.index');
        } 
    	return Redirect::route('users.create') ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }


    public function edit($id){
        $user = User::find($id);             //find a user from User model(extracted from db) with this id
        if (is_null($user)){                 //if not found return to same page
        	return Redirect::route('users.index'); 
        } 
        return View::make('users.edit', compact('user')); 
    }

    
    public function update($id){            //method to update a user in user model
    	$input = Input::all();              // input specifies the values from the web
    	$validation = Validator::make($input, User::$rules); 
    	if ($validation->passes()){ 
    		$user = User::find($id);              // it finds the row with $id and stores it in the user variable
    		$user->update($input);                // update the value stored in database with input values from user values
    		return Redirect::route('users.show', $id); 
    	} 
    	return Redirect::route('users.edit', $id) ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }

    public function destroy($id) {        //it calls the method delete
    	User::find($id)->delete();        //fine user with a value in id and delete it from user model
    	return Redirect::route('users.index'); 
    } 



    public function showLogin()
    {   
    // show the form
       return View::make('login');
    }

    public function doLogin()
    {
        $rules = array(
        'uname'    => 'required|min:3', // make sure the username is required and greater than 3
        'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 cha
        );
          

        




        //rums the validator on inputs
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
                return Redirect::to('login')
                    ->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
      
        }  else {
                // create our user data for the authentication
                $webuserdata =
                 array(
                'username'     => Input::get('uname'),           //with label name = uname;
                'password'  => Input::get('password')
                );  
                
                //$webusername = $webuserdata['username'];
                //$webpassword = $webuserdata['password'];

                $dbuserdata = User::where('username', $webuserdata['username'] )->first();

               // $dbuserdata = User::find($webuserdata['username']);
            }
        // attempt to do the login
        if ( $webuserdata['password']==$dbuserdata['password']) {
        
            if (is_null($dbuserdata)){
                echo'fail';
                echo $webuserdata['username'];
                //echo $webuserdata;
                
            }

        echo $dbuserdata['password'];
        // validation successful!
        // redirect them to the secure section or whatever
        return Redirect::to('admin');
        // for now we'll just echo success (even though echoing in a controller is bad)
         
        }  else {        
        // validation not successful, send back to form 
        	//echo $ud['uname'];
        	//echo $webuserdata['password'];

            //echo $webuserdata['username'];
        	//echo $dbuserdata;
        return Redirect::to('login');

        }
    }
}



**/