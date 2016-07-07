<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;

use App\math_symbols;

use DB;

use  Request;

use App\equations;

use App\tags;
use Auth;

class NavController extends Controller
{
    //



   public function __construct()
    {
        
        $this->middleware('auth');
    } 


    public function sendOption($option){
        if( Auth::check()){
    	if($option==="Compose"){
            $equations = DB::table('equations')->get();
            $symbol_group = DB::table('math_symbols_group')->get();
            $symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
            $tags =  tags::lists('name','id');
            
            return view('users.compose',compact('option','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','equations','tags'));
        }
        elseif ($option==="Review") {
            return view('users.review',compact('option'));   
        }

        elseif ($option==="Browse") {
            return view('users.browse',compact('option'));
        }

        elseif ($option==="History") {
            return view('users.history',compact('option'));
        }

        elseif ($option==="Home") {
            return view('users.home',compact('option'));
        }

        else{
            return view('users.questions',compact('option'));     
        }  
    }
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
