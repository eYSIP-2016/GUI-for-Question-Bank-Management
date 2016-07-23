<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;

use App\math_symbols;

use DB;

use  Request;

use App\equations;
use App\Q_description;
use App\Q_table;
use App\Q_tag_relation;
use App\code;
use App\options;

use App\tags;
use App\users;


use Auth;

class NavController extends Controller
{
    //


    //calling middleware
   public function __construct()
    {
        
        $this->middleware('auth');
    } 

    //sending option to views
    
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

            $user = Auth::id();
            $tags = tags::lists('name','id');

            $review_q_id = DB::table('reviews')
                            ->where('reviewed',0)
                            ->where('alloted',1)
                            ->where('u_id',$user)
                            ->lists('q_id');


            $review_questions = DB::table('q_tables')
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
                                 'q_tables.q_id AS question_id')
                        ->whereIn('q_tables.q_id',$review_q_id);

            $results = $review_questions->count();
            $review_questions = $review_questions->paginate(4);
            return view('users.review',compact('option','review_questions','tags','results'));

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



            return view('users.browse',compact('option','tags','questions','results'));
        }

        elseif ($option==="History") {
            $user = Auth::id();            
            $tags =  tags::lists('name','id');

            $revision = DB::table('revisions')->where('action','updated')->distinct()->lists('row_id');
            
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
                                 'q_tables.tag_revision AS tag_revision',
                                 'q_tables.version AS version')
                        ->where('q_tables.created_by','=',$user)
                        ->whereIn('q_id',$revision);
                        //->whereIn('q_tables.q_id',$r_q_id) 
            $results = $questions->count();

            $questions = $questions->paginate(4);

            return view('users.history',compact('option','tags','questions','results','revision'));
        }

        elseif ($option==="Home") {
            $user = Auth::id();
            $tags = tags::lists('name','id');
            $symbol_group = DB::table('math_symbols_group')->get();
            $symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
            
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
                                 'q_tables.tag_revision AS tag_revision')
                        ->where('q_tables.created_by',$user);

            $results = $questions->count();
            $questions = $questions->paginate(4);
            return view('users.home',compact('option','questions','tags','results','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6'));
        }

        else{


            $user = Auth::id();
            $tags = tags::lists('name','id');
            $symbol_group = DB::table('math_symbols_group')->get();
            $symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
            $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
            $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
            $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
            $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
            $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();
            
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
                                 'q_tables.tag_revision AS tag_revision')
                        ->where('q_tables.created_by','=',$user);

            $results = $questions->count();
            $questions = $questions->paginate(4);
            return view('users.home',compact('option','questions','tags','results','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6'));
            return view('users.home',compact('option'));     
        }  
    
    }

}
}