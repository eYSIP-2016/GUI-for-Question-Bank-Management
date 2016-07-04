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

Route::get('welcomeGUI',function(){
	return view('GUI_Q_Bank_Views.Welcome_page_GUI_Q_Bank');
});

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

//Maiintain a file system for images dont keep a database
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

Route::get('testhome/{option}','NavController@sendOption');

Route::post('/','NavController@createEquation');

Route::get('testhome/{option}','NavController@sendOption');

Route::resource('users','UserController');

Route::resource('authenticate','UserController@authenticate');

Route::bind('', function($value, $route) {
	return App\User::whereSlug($value)->first();
});