<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Request;
use Illuminate\Support\Facades\URL;

use App\q_description;
use DB;
use App\q_table;
use App\q_tag_relation;
use App\code;
use App\equations;
use App\options;
use App\revision_q_description;
use App\revision_options;
use App\revision_q_table;
use App\revision_q_tag_relation;
use App\revision_code;
use App\revision_equations;
use App\tags;
use File;

class QuestionController extends Controller
{
 	public function create(){

 		$input = Request::all();
 		$time = time();
        $date = date("Y-m-d",$time);

 		$question = new q_table();
 		$user = 1;
 		$question->created_by = $user;
 		$question->last_edited_by = $user;

 		$r_question = new revision_q_table(); 
 		$r_question->edited_by = $user;

 		$q_description = new q_description();
 		$r_q_description = new revision_q_description();



        /*************Storing equations******************/
 		$exp = Request::get('Q_exp');
 		if (!is_null($exp)&&!empty($exp)) {
			$equation = new equations();
	 		$r_equation = new revision_equations();
	 		
	 		$equation->exp_latex = $exp;
	 		
	 		$equation_URL = Request::get('hidden_exp_url');
	        $name = 'equation'.$date.$time.'.gif';
	 		$path = storage_path().'/images/'.$name;
	        file_put_contents($path, file_get_contents($equation_URL));

	        $path = URL::to('/').'/images/'.$name;
	        $equation->exp_image = $path;
	        $equation->save();

	        $eq_id = $equation->getKey();
	        $question->exp_id = $eq_id;
	        $r_question->exp_id = $eq_id;

	 		$r_equation->exp_id = $eq_id;
	 		$r_equation->r_id = 0;

	 		$r_equation->exp_latex = $exp; 

	 		$path = storage_path() . '/revisions/' . $name;
	        file_put_contents($path, file_get_contents($equation_URL));

	        $path = URL::to('/').'/revisions/'.$name;
	        $r_equation->exp_image = $path;

	       	$r_equation->save();

 		}


 		/*************Storing codes******************/
 		$code_description = Request::get('Q_code');
 		
 		if (!is_null($code_description)&&!empty($code_description)) {
			$code = new code();
	 		$r_code = new revision_code();

	 		$code->code_description = $code_description;
	 		
	 		$code_URL = Request::get('hidden_code_url');
	        $name = 'code'.$date.$time.'.png';
	 		$path = storage_path().'/images/'.$name;
	        file_put_contents($path, file_get_contents($code_URL));

	        $path = URL::to('/').'/images/'.$name;
	        $code->code_image_path = $path;


	        $code->save();

	        $code_id = $code->getKey(); 
	        $question->code_id = $code_id;
	        $r_question->code_id = $code_id;

	 		$r_code->code_id = $code_id;
	 		$r_code->r_id = 0;

	 		$r_code->code_description = $code_description; 

	 		$path = storage_path().'/revisions/'.$name;
	        file_put_contents($path, file_get_contents($code_URL));

	        $path = URL::to('/').'/revisions/'.$name;
	        $r_code->code_image_path = $path;

	        $r_code->save();
 		}


 		/************storing diagrams*******************/
 			# code...
	 	if(!is_null(Request::file('Q_diagram'))){
	 			if (Request::file('Q_diagram')->isValid()){
	            $file = Request::file('Q_diagram');
	            $time = time();
	            $date = date("Y-m-d",$time);
	            $extension = Request::file('Q_diagram')->getClientOriginalExtension();
	            $name = 'diagram'.$date.$time.'.'.$extension;
	            $path = storage_path().'/images/'.$name;
	            File::copy($file, $path);

	            $path = URL::to('/');
	            $question->diagram_path = $path.$name;

	            $path = storage_path() . '/revisions/';
	            $file->move($path, $name);

	            $path = URL::to('/');
	            $r_question->diagram_path = $path.'/revisions/'.$name;
	        }
	    }


        /************Difficulty level**************/
        $question->difficulty = Request::get('difficulty');
        $r_question->difficulty = Request::get('difficulty');



        /***********Time***************************/
        $question->time = Request::get('timeRequired');
        $r_question->time = Request::get('timeRequired');

        if (!is_null(Request::get('no_questions'))) {
        	# code...
        	$question->options = 1;
        	$r_question->options = 1;
        }
        $question->save();

 		$q_id = $question->getKey();
 		$r_question->q_id = $q_id;
        $r_question->save();



 		/********Storing question description***********/
 		$q_description->q_id = $q_id;
 		$q_description->description = Request::get('Q_desc');
 		$description_image_URL = Request::get('hidden_desc_url');
        $name = 'question'.$date.$time.'.png';
 		$path = storage_path().'/images/Question/'.$name;
        file_put_contents($path, file_get_contents($description_image_URL));

        $path = URL::to('/').'/images/'.$name;
        $q_description->image_path = $path;

        $r_q_description->q_id = $q_id;
        $r_q_description->description = Request::get('Q_desc');
        $name = 'question'.$date.$time.'.png';
 		$path = storage_path().'/revisions/'.$name;
        file_put_contents($path, file_get_contents($description_image_URL));

        $path = URL::to('/').'/revisions/'.$name;
        $r_q_description->image_path = $path;



        /**************Storing Options****************/

        $option_no = Request::get('no_questions');
        if (!is_null($option_no)) {
        	$option = new options();
	        $revision_option = new revision_options();
	        for ($i = 1 ; $i <= $option_no ; $i++ ) {
	            # code...
	            $option = new options();
	            $revision_option = new revision_options();
	    
	            $name_option = 'member'.($i-1);
	            $text = Request::get($name_option);
	            $answer = Request::get('answer');

	            $option->q_id = $q_id;//take value from Question table
	            $option->option_no = $i;
	            $option->description = $text;
	            $option->correct_ans = $answer;
	            $option->save();

	            $revision_option->op_no = $i;
	            $revision_option->desc = $text;
	            $revision_option->correct_ans = $answer;
	            $revision_option->r_id = 0;
	            $revision_option->q_id = $q_id;
	            $revision_option->save();
	        }
	         
        }
        
        /*****************Adding tags********************/
        foreach(Request::get('tags') as $selected_tag){
	        $tag_R = new q_tag_relation();
	        $r_tag_R = new revision_q_tag_relation();

	        $tag_R->q_id = $q_id;
	        $tag_R->tag_id = $selected_tag;

			$r_tag_R->q_id = $q_id;
	        $r_tag_R->tag_id = $selected_tag;	        
	        $r_tag_R->r_id = 0;

	    	$tag_R -> save();
	    	$r_tag_R -> save();
        }

        $q_description->save();
        $r_q_description->save();

    	return redirect('testhome/compose');
 	}



 	public function getSearchResults(){

 		$search_string = Request::get('search_item'); 

 		$search_tags = Request::get('tags');

 		$question_from_tags = q_tag_relation::whereIn('tag_id',$search_tags)->lists('q_id');

 		$question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('q_id');

 		$option = 'Browse';

 		if(empty($search_string)){
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
                                 'reviewer.name AS reviewer')
            			->whereIn('q_tables.q_id',$question_from_tags)->orderBy('q_tables.updated_at','desc');
        }
        else{
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
                                 'reviewer.name AS reviewer')
            			->whereIn('q_tables.q_id',$question_from_tags)
            			->orWhere('q_tables.q_id',$question_from_description)
            			->orderBy('q_tables.updated_at','desc');
        }

        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('GUI_Q_Bank_Views.user_acc_browse',compact('option','tags','questions','results'));
 	}
}
