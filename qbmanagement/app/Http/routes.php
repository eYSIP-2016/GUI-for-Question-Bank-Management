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




Route::group(['middleware' => 'web'] , function(){

    Route::get('/', [ function () {
        if ( Auth::check() ) // use Auth::check to check if there is any authorised user
        {
            if ( Auth::user()->user_type_id == 1)
                return redirect('home');
            else 
                return
                  redirect('questions');
        } else{
              return view('auth.login');
        }
    //return Redirect::to('testhome');
    }]);



    Route::get('questions/', [ 'middleware' => 'auth',
    'as' => 'questions', function () {
    $option="";
    return view('users.questions',compact('option'));

    }]);



    Route::get('questions/{option}',[ 'middleware' => 'auth' ,'as' => 'question', 'uses' =>'NavController@sendOption']);

    Route::post('/','NavController@createEquation');
    
    Route::get('images/{filename}', function ($filename)
    {
        $path = storage_path() . '/images/' . $filename;

        if(!File::exists($path)) abort(404);

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
   

     
    //Route::post('register', 'Auth\AuthController@postRegister');

    Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::resource('users','Auth\AuthController');

});


