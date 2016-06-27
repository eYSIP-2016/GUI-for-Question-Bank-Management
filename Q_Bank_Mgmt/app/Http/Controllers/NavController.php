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
    		//$symbols=DB::table('math_symbols')->get();
    		$tags=['algorithms','data structures','Queue'];
    		return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option','tags'));
    	}
    	return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
    }
}