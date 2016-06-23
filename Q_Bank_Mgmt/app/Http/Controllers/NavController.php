<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use DB;

class NavController extends Controller
{
    //
    public function sendOption($option){
    	if($option==="compose"){
    		$tags=['algoriths','hello','world','lotr'];
    		return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option','tags'));
    	}
    	return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
    }
}