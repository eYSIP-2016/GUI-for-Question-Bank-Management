<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class NavController extends Controller
{
    //
    public function sendOption($option){
    	return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
    }
}