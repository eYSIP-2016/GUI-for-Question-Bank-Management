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
use App\diagram;
use App\users;

class NavController extends Controller
{
    //
    public function sendOption($option){
    	if($option==="compose"){
            $symbol_group = DB::table('math_symbols_group')->get();
    		$symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
    		$tags =  tags::lists('name','id');
            
    		return view('GUI_Q_Bank_Views.user_acc_compose',compact('option','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags'));
    	}
        elseif ($option==="Review") {
            return view('GUI_Q_Bank_Views.user_acc_review',compact('option'));   
        }

        elseif ($option==="Browse") {
            $tags =  tags::lists('name','id');
            $questions = DB::table('q_tables')
                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
                        ->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
                        ->leftJoin('users AS creator','q_tables.created_by','=','creator.id')
                        ->leftJoin('users AS reviewer','q_tables.last_edited_by','=','reviewer.id')
                        ->leftJoin('difficulty AS difficulty','q_tables.difficulty','=','difficulty.key')
                        ->leftJoin('category AS category','q_tables.category','=','category.key')
                        ->select('diagrams.path AS diagram',
                                 'q_tables.q_id AS q_id',
                                 'q_tables.options AS option',
                                 'difficulty.name AS difficulty',
                                 'category.name AS category',
                                 'q_tables.time AS time',
                                 'q_descriptions.description AS desc',
                                 'equations.exp_image AS equation',
                                 'codes.code_image_path AS code',
                                 'creator.name AS creator',
                                 'reviewer.name AS reviewer',
                                 'q_tables.q_id AS question_id',
                                 'q_tables.tag_revision AS tag_revision');

            $results = $questions->count();

            $questions = $questions->paginate(4);

            return view('GUI_Q_Bank_Views.user_acc_browse',compact('option','tags','questions','results'));
        }

        elseif ($option==="History") {
            return view('GUI_Q_Bank_Views.user_acc_history',compact('option'));
        }

        elseif ($option==="Home"||$option==="") {

            $user = Auth::id();
            $tags = tag::lists('name','id');
            $symbol_group = DB::table('math_symbols_group')->get();
            $symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
            $tags = tags::lists('name','id');
            $questions = DB::table('q_tables')
                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
                        ->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
                        ->leftJoin('users AS creator','q_tables.created_by','=','creator.id')
                        ->leftJoin('users AS reviewer','q_tables.last_edited_by','=','reviewer.id')
                        ->leftJoin('difficulty AS difficulty','q_tables.difficulty','=','difficulty.key')
                        ->leftJoin('category AS category','q_tables.category','=','category.key')
                        ->select('diagrams.path AS diagram',
                                 'q_tables.q_id AS q_id',
                                 'q_tables.options AS option',
                                 'difficulty.name AS difficulty',
                                 'category.name AS category',
                                 'q_tables.time AS time',
                                 'q_descriptions.description AS desc',
                                 'equations.exp_image AS equation',
                                 'codes.code_image_path AS code',
                                 'creator.name AS creator',
                                 'reviewer.name AS reviewer',
                                 'q_tables.q_id AS question_id',
                                 'q_tables.tag_revision AS tag_revision')->where('q_tables.created_by','=',$user);

            $results = $questions->count();

            $questions = $questions->paginate(4);
            
            return view('GUI_Q_Bank_Views.user_acc_home',compact('option','tags','questions','results','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6'));
        }

        else{
            return view('GUI_Q_Bank_Views.User_Acc_Home_Page',compact('option'));     
        }
    }
}

