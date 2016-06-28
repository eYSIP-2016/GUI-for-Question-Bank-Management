<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\math_symbols;

use DB;

use Request;

use App\equations;
class NavController extends Controller
{
    //
    public function sendOption($option){
    	if($option==="compose"){
            $equations = DB::table('equations')->get();
    		$symbols = DB::table('maths_symbols')->get();
    		$tags =  DB::table('tags')->get();
            
    		return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option','symbols','tags','equations'));
    	}
    	return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
    }

    public function createEquation(){

    	$input = Request::all();
    	
    	$pathToImage = Request::get('hiddenId');

    	$image = file_get_contents($pathToImage);




    	$equation = new equations();

        //$equation->id = 

    	$equation->exp_latex = Request::get('Q_exp');

    	$equation->exp_image = $image;

    	$equation->save();

    	return $input;

    }

}