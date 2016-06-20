<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PagesController extends Controller
{
    public function home(){
	    $projects = ['hello','hell','lion'];
		return view('projects.listview',compact('projects'));
    }

    public function about(){
    	return view('pages.about');
    }
}
