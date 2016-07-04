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
            $symbol_group = DB::table('math_symbols_group')->pluck('group_name');
    		$symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
    		$tags =  DB::table('tags')->get();
            
    		return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','equations'));
    	}
    	return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));
    }

    public function createEquation(){

    	$input = Request::all();
    	
        $URLToImage = 'http://api.img4me.com/?text=Testing&font=arial&fcolor=000000&size=10&bcolor=FFFFFF&type=png';
        $pathToImage = file_get_contents($URLToImage);

        $time = time();

        $date = date("Y-m-d",$time);

        $name = $date.$time.'.png';

        $path = storage_path() . '/images/' . $name;



        file_put_contents($path, file_get_contents($pathToImage));

    	$equation = new equations();

    	$equation->exp_latex = Request::get('Q_exp');

    	$equation->exp_image = $path;

    	$equation->save();

    	return $input;

    }

}