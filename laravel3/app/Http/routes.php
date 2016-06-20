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

Route::get('cards','CardsController@index');

Route::get('about','PagesController@about');

Route::get('projectone','PagesController@home');

Route::get('cards/{id}', 'CardsController@showCard');