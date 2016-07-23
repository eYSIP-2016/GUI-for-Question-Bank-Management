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



    
Route::auth();    

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

/******************Routes for Admin************************************/    

    Route::get('adminhome/', [ 'middleware' => 'adm',
            'as' => 'adminhome', function () {
            return redirect('adminhome/New_questions');
        }]);
    
    Route::get('adminhome/submitforreview', ['as' => 'adminhomesubmit','uses' => 'Auth\AuthController@distribute']);

    Route::get('adminhome/{option}',[ 'middleware' => 'adm' ,'as' => 'adminshome', 'uses' =>'Auth\AuthController@sendOption']);

    Route::get('adminhome/Browse/{action}/{question_id}','Auth\AuthController@editOrPickQuestion');

    Route::post('adminhome/Browse/Edit/{question_id}','Auth\AuthController@makeChanges');


    Route::get('auth/register','Auth\AuthController@showRegistrationForm');

    Route::post('auth/register', 'Auth\AuthController@postRegister');

    Route::delete('adminhome/Users/Delete/{users}',['as' => 'users.destroy','uses' => 'Auth\AuthController@destroy']);

    Route::post('adminhome/Tags/Add',['as' => 'tags.store' , 'uses' => 'tagsController@store']);
   
    Route::delete('adminhome/Tags/Delete/{tags}',['as' => 'tags.destroy' , 'uses' => 'tagsController@destroy']);






/*********************************Routes for Users***************************************/


    Route::get('usershome/', [ 'middleware' => 'auth',
    'as' => 'usershome', function () {
    return redirect('usershome/Home');

    }]);

    Route::post('usershome/Home','QuestionController@getUsersQuestions');


    Route::get('usershome/Home/{action}/{question_id}','QuestionController@editOrPickQuestion');

    Route::post('usershome/Home/Edit/{question_id}','QuestionController@makeChanges');
    

    Route::post('usershome/Home/Pick/{question_id}','QuestionController@create');


    Route::get('usershome/{option}',[ 'middleware' => 'auth' ,'as' => 'usershome', 'uses' =>'NavController@sendOption']);

    Route::post('usershome/Compose','QuestionController@create');

    
    Route::post('usershome/Browse','QuestionController@getSearchResults');


    Route::get('usershome/Browse/{action}/{question_id}','QuestionController@editOrPickQuestion');

    Route::post('usershome/Browse/Pick/{question_id}','QuestionController@create');



    Route::get('usershome/Review/{action}/{question_id}','QuestionController@editOrPickQuestion');

    Route::get('usershome/Review/Reviewed/{question_id}','QuestionController@reviewed');


    Route::post('usershome/Review/Modify/{question_id}','QuestionController@makeChanges');


    Route::get('usershome/History/{question_id}/{version_no}','QuestionController@version');

    Route::get('usershome/Restore/{question_id}/{version_no}', ['as'=>'restore', 'uses'=>'QuestionController@revise']);

    Route::delete('usershome/Home/Delete/{question_id}',['as' => 'question.destroy','uses' => 'QuestionController@delete']);


/*************************Routes to get files******************************************/ 

   
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

});

