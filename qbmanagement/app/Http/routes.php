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
                return redirect('adminhome');
            else 
                return
                  redirect('usershome');
        } 
        else{
              return view('auth.login');
        }
    //return Redirect::to('testhome');
    }]);



    Route::get('usershome/', [ 'middleware' => 'auth',
    'as' => 'usershome', function () {
    $option="";
    return view('users.usershome',compact('option'));

    }]);


    Route::get('adminhome/', [ 'middleware' => 'adm',
    'as' => 'adminhome', function () {
    $option="";
    return view('admin.adminhome',compact('option'));

    }]);


    Route::get('adminhome/submitforreview', ['as' => 'adminhomesubmit','uses' => 'Auth\AuthController@distribute']);

    Route::get('usershome/{option}',[ 'middleware' => 'auth' ,'as' => 'usershome', 'uses' =>'NavController@sendOption']);
    
    Route::get('adminhome/{option}',[ 'middleware' => 'adm' ,'as' => 'adminshome', 'uses' =>'Auth\AuthController@sendOption']);


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
   

    Route::post('usershome/Compose','QuestionController@create');

    Route::post('usershome/Browse','QuestionController@getSearchResults');

    Route::get('usershome/Home/{action}/{question_id}','QuestionController@editOrPickQuestion');

    Route::get('usershome/Browse/{action}/{question_id}','QuestionController@editOrPickQuestion');

    Route::post('usershome/Home/Edit/{question_id}','QuestionController@makeChanges');
    
    Route::delete('usershome/Home/Delete/{question_id}',['as' => 'question.destroy','uses' => 'QuestionController@delete']);
    
    Route::post('usershome/Home/Pick/{question_id}','QuestionController@create');

    Route::post('usershome/Browse/Pick/{question_id}','QuestionController@create');

    Route::get('usershome/History/{question_id}/{version_no}','QuestionController@version');

    Route::get('usershome/Restore/{question_id}/{version_no}', ['as'=>'restore', 'uses'=>'QuestionController@revise']);
     
    //Route::post('register', 'Auth\AuthController@postRegister');

    Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::auth();

    Route::get('/home', 'HomeController@index');

    Route::resource('users','Auth\AuthController');


    Route::get('{folder}/{filename}', function ($folder, $filename)
    {
        if($folder==='images'||$folder==='revisions'){
            $path = storage_path() . '/'.$folder.'/' . $filename;

            if(!File::exists($path)) abort(404);

            $file = File::get($path);
            $type = File::mimeType($path);
  
            $response = Response::make($file, 200);
            $response->header("Content-Type", $type);

            return $response;
        }
        else{
            abort(404);
        }
    });


    

    //Route::group(['middleware' => 'adm'], function()
    //{
       Route::resource('tags','tagsController');
     //});

});

