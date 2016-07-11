<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\math_symbols;

use DB;

use Request;

use App\Q_description;
use App\Q_table;
use App\Q_tag_relation;
use App\code;
use App\equations;
use App\options;
use App\revision_Q_description;
use App\revision_options;
use App\revision_Q_table;
use App\revision_Q_tag_relation;
use App\revision_code;
use App\revision_equations;
use App\tags;
use App\users;

class NavController extends Controller
{
    //
    public function sendOption($option){
    	if($option==="compose"){
            $equations = DB::table('equations')->get();
            $symbol_group = DB::table('math_symbols_group')->get();
    		$symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
    		$tags =  tags::lists('name','id');
            
    		return view('GUI_Q_Bank_Views.user_acc_compose',compact('option','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','equations','tags'));
    	}
        elseif ($option==="Review") {
            return view('GUI_Q_Bank_Views.user_acc_review',compact('option'));   
        }

        elseif ($option==="Browse") {
            $tags =  tags::lists('name','id');
            $questions = DB::table('q_tables')
                        ->leftJoin('q_descriptions','q_tables.q_id','=','q_descriptions.q_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
                        ->leftJoin('users AS creator','q_tables.created_by','=','creator.id')
                        ->leftJoin('users AS reviewer','q_tables.last_edited_by','=','reviewer.id')
                        ->select('q_tables.diagram_path AS diagram',
                                 'q_tables.q_id AS q_id',
                                 'q_tables.options AS option',
                                 'q_tables.difficulty AS difficulty',
                                 'q_tables.time AS time',
                                 'q_descriptions.description AS desc',
                                 'equations.exp_image AS equation',
                                 'codes.code_image_path AS code',
                                 'creator.name AS creator',
                                 'reviewer.name AS reviewer');

            $results = $questions->count();

            $questions = $questions->paginate(4);

            return view('GUI_Q_Bank_Views.user_acc_browse',compact('option','tags','questions','results'));
        }

        elseif ($option==="History") {
            return view('GUI_Q_Bank_Views.user_acc_history',compact('option'));
        }

        elseif ($option==="Home") {
            return view('GUI_Q_Bank_Views.user_acc_home',compact('option'));
        }

        else{
            return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));     
        }
    }

    public function createEquation(){

    	$input = Request::all();
    	
        /*$URLpt1 = 'http://api.img4me.com/?text=';
        $text = Request::get('Q_exp');
        $URLpt2 = '&font=arial&fcolor=000000&size=10&bcolor=FFFFFF&type=png';
        $pathToImage = file_get_contents($URLpt1.$text.$URLpt2);

        $time = time();

        $date = date("Y-m-d",$time);

        $name = $date.$time.'.png';

        $path = storage_path() . '/images/' . $name;



        file_put_contents($path, file_get_contents($pathToImage));

    	$equation = new equations();

    	$equation->exp_latex = $text;

    	$equation->exp_image = $path;

    	$equation->save();*/

        /*$option_no = Request::get('options_no');
        $option = new options();
        $revision_option = new revision_options();
        for ($i = 1 ; $i <= $option_no ; $i++ ) {
            # code...
            $option = new options();
            $revision_option = new revision_options();
    
            $name_option = 'member'.($i-1);
            $text = Request::get($name_option);
            $answer = Request::get('answer');

            $option->q_id = 2;//take value from Question table
            $option->option_no = $i;
            $option->description = $text;
            $option->correct_ans = $answer;
            $q_id = $option->q_id;
            $option->save();

            $revision_option->op_no = $i;
            $revision_option->desc = $text;
            $revision_option->correct_ans = $answer;
            $revision_option->r_id = 0;
            $revision_option->q_id = $q_id;
            $revision_option->save();
        }*/

        /*if (Request::file('Q_diagram')->isValid()){
            $file = Request::file('Q_diagram');
            $time = time();
            $date = date("Y-m-d",$time);
            $extension = Request::file('Q_diagram')->getClientOriginalExtension();
            $name = $date.$time.'.'.$extension;
            $path = storage_path() . '/diagrams/';
            Request::file('Q_diagram')->move($path, $name);
        }*/
        $time = time();
        $date = date("Y-m-d",$time);
        $q_id =0;
        $q_description = new Q_description();
        $r_q_description = new revision_Q_description();

        $q_description->q_id = $q_id;
        $q_description->description = Request::get('Q_desc');
        //$description_image_URL = Request::get('hidden_desc_url');
        $description_image_URL = 'https://latex.codecogs.com/gif.latex?hello';
        $name = 'question'.$date.$time.'.gif';
        $path = storage_path().'/images/'.$name;
        file_put_contents($path, file_get_contents($description_image_URL));
        $q_description->image_path = $path;


    	return $input;

    }
}

