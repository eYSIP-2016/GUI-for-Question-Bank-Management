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
    return view('welcome');
});

Route::post('testhome/compose','QuestionController@create');

Route::post('testhome/Browse','QuestionController@getSearchResults');

Route::post('testhome/Home','QuestionController@getUsersQuestions');

Route::get('testhome/Home/{action}/{question_id}','QuestionController@editOrPickQuestion');

Route::get('testhome/Browse/{action}/{question_id}','QuestionController@editOrPickQuestion');

Route::get('testhome/Review/{action}/{question_id}','QuestionController@editOrPickQuestion');

Route::post('testhome/Home/Edit/{question_id}','QuestionController@makeChanges');

Route::post('testhome/Home/Pick/{question_id}','QuestionController@create');

Route::post('testhome/Browse/Pick/{question_id}','QuestionController@create');

Route::post('credentials', [
    'as' => 'credentials', 'uses' => 'UserController@doLogin'
]);

Route::get('authenticate/{users}', [
    'as' => 'authenticate', 'uses' => 'UserController@authenticate'
]);

Route::get('testhome',[ 
	'as' => 'testhome', function () {
	$option="";
    return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
}]);

Route::get('testhome/{option}','NavController@sendOption');



//a file system is maintained for images 
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

Route::resource('users','UserController');

Route::resource('authenticate','UserController@authenticate');

Route::bind('', function($value, $route) {
	return App\User::whereSlug($value)->first();
});

Route::get('admin', function(){
    return view('users.admin');
});