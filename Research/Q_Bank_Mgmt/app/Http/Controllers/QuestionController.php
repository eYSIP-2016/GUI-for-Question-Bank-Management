<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Log;

use Request;
use Illuminate\Support\Facades\URL;

use App\q_description;
use DB;
use App;
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
use App\diagram;
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


        /*************Storing equations******************/
 		$exp = Request::get('Q_exp');
 		if (!empty($exp)) {
			$equation = new equations();
	 		
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

 		}


 		/*************Storing codes******************/
 		$code_description = Request::get('Q_code');
 		
 		if (!empty($code_description)) {
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
 		}


 		/************storing diagrams*******************/
 		# code...
	 	if(!is_null(Request::file('Q_diagram'))){
	 			$diagram = new diagram();
	 			if (Request::file('Q_diagram')->isValid()){
	            $file = Request::file('Q_diagram');
	            $time = time();
	            $date = date("Y-m-d",$time);
	            $extension = Request::file('Q_diagram')->getClientOriginalExtension();
	            $name = 'diagram'.$date.$time.'.'.$extension;
	            $path = storage_path().'/images/'.$name;
	            File::copy($file, $path);

	            $path = URL::to('/');
	            $diagram->path = $path.'/images/'.$name;
	            $diagram->save();

	            $question->diagram_id = $diagram->getKey();
	        }
	    }


 		/************Category**************/
        $question->category = Request::get('category');


        /************Difficulty**************/
        $question->difficulty = Request::get('difficulty');



        /***********Time***************************/
        $question->time = Request::get('timeRequired');

        if (!empty(Request::get('no_questions'))) {
        	# code...
        	$question->options = 0;
        }


        /********Storing question description***********/
        $q_description = new q_description();

        $q_description->description = Request::get('Q_desc');
        $description_image_URL = Request::get('hidden_desc_url');
        $name = 'question'.$date.$time.'.png';
        $path = storage_path().'/images/'.$name;
        file_put_contents($path, file_get_contents($description_image_URL));

        $path = URL::to('/').'/images/'.$name;
        $q_description->image_path = $path;

        $q_description->save();
        $description_id = $q_description->getKey();

        $question->description_id = $description_id;

        $question->save();

 		$q_id = $question->getKey();



        /**************Storing Options****************/

        $option_no = Request::get('no_questions');
        if (!empty($option_no)) {
        	$option = new options();
	        for ($i = 1 ; $i <= $option_no ; $i++ ) {
	            # code...
	            $option = new options();
	    
	            $name_option = 'member'.($i);
	            $text = Request::get($name_option);
	            $answer = Request::get('answer');

	            $option->q_id = $q_id;//take value from Question table
	            $option->option_no = $i;
	            $option->description = $text;
	            $option->correct_ans = $answer;
                $option->revision = 0;
	            $option->save();
	        }
	         
        }
        
        /*****************Adding tags********************/
        foreach(Request::get('tags') as $selected_tag){
	        $tag_R = new q_tag_relation();

	        $tag_R->q_id = $q_id;
	        $tag_R->tag_id = $selected_tag;

	    	$tag_R -> save();
        }

    	return redirect('testhome/compose');
 	}



 	public function getSearchResults(){

 		$search_string = Request::get('search_item'); 

 		$question_from_tags = q_tag_relation::
                        leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
                        ->where('tags.name','LIKE','%'.$search_string.'%')
                        ->lists('q_id');

 		$question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');

 		$option = 'Browse';
        	
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
                                 'q_tables.q_id AS question_id',
                                 'creator.name AS creator',
                                 'reviewer.name AS reviewer',
                                 'q_tables.tag_revision AS tag_revision')
            			->whereIn('q_tables.q_id',$question_from_tags)
            			->orWhereIn('q_tables.description_id',$question_from_description)
            			->orderBy('q_tables.updated_at','desc');
        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('GUI_Q_Bank_Views.user_acc_browse',compact('option','questions','results'));
 	}

 	public function getUsersQuestions(){
        $search_string = Request::get('search_item');

 		$user = 2;

 		$tags =  tags::lists('name','id');

 		$question_from_tags = q_tag_relation::
                        leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
                        ->where('tags.name','LIKE','%'.$search_string.'%')
                        ->lists('q_id');

 		$question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');

 		$option = 'Home';
        
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
                                 'q_tables.created_by AS created_by',
                                 'equations.exp_image AS equation',
                                 'codes.code_image_path AS code',
                                 'q_tables.q_id AS question_id',
                                 'creator.name AS creator',
                                 'reviewer.name AS reviewer',
                                 'q_tables.tag_revision AS tag_revision')
                        ->where('created_by','=',$user)
                        ->where(function ($query) {
                            $search_string = Request::get('search_item');
                            $question_from_tags = q_table::
                                        leftJoin('q_tag_relations','q_tables.q_id','=','q_tag_relations.q_id')
                                        ->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
                                        ->where('q_tables.tag_revision','q_tag_relations.tag_revision')
                                        ->where('tags.name','LIKE','%'.$search_string.'%')
                                        ->lists('q_tag_relations.q_id');

                            $question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');
                            
                            $query->whereIn('q_tables.q_id',$question_from_tags)
                                  ->orWhereIn('q_tables.description_id',$question_from_description);
                        })->orderBy('q_tables.updated_at','desc');

            $questions = $questions;

        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('GUI_Q_Bank_Views.user_acc_home',compact('option','tags','questions','results'));
 	}

 	public function editOrPickQuestion($action, $question_id){
 		if($action ==="Edit"|| $action==="Pick" || $action==="Review"){
	 		$symbol_group = DB::table('math_symbols_group')->get();
	    	$symbols_1 = DB::table('maths_symbols')->where('type','1')->get();
	        $symbols_2 = DB::table('maths_symbols')->where('type','2')->get();
	        $symbols_3 = DB::table('maths_symbols')->where('type','3')->get();
	        $symbols_4 = DB::table('maths_symbols')->where('type','4')->get();
	        $symbols_5 = DB::table('maths_symbols')->where('type','5')->get();
	        $symbols_6 = DB::table('maths_symbols')->where('type','6')->get();

	 		$tags =  tags::lists('name','id');

	 		$question = DB::table('q_tables')
	 						->where('q_tables.q_id','=',$question_id)
	                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
	                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        	->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
	                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
	                        ->leftJoin('difficulty AS difficulty','q_tables.difficulty','=','difficulty.key')
	                        ->leftJoin('category AS category','q_tables.category','=','category.key')
	                        ->select('diagrams.path AS diagram',
	                                 'q_tables.options AS option',
	                                 'q_tables.time AS time',
	                                 'difficulty.name AS difficulty',
	                                 'category.name AS category',
	                                 'q_descriptions.description AS description',
	                                 'equations.exp_latex AS equation',
	                                 'codes.code_description AS code',
	                                 'q_tables.q_id AS question_id',
	                                 'q_tables.options AS opt_used',
                                     'q_tables.tag_revision AS tag_revision')->first();

	        $options_used = $question->opt_used;
	        if (!is_null($options_used)) {

	        	$option_object = options::where('q_id',$question_id)->where('revision',$options_used
                    )->first();
		        $correct_ans = $option_object->correct_ans;

		        return view('GUI_Q_Bank_Views.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','correct_ans','action'));
	        }
	        else{
	        	return view('GUI_Q_Bank_Views.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','action'));
	        }
	        
    	}
    	else{
    		App::abort(403, 'No such Page');
    	}
	}

	public function makeChanges($question_id){
		$time = time();
        $date = date("Y-m-d",$time);
        $user = '2';
		$question = DB::table('q_tables')
 						->where('q_tables.q_id','=',$question_id)
                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
                        ->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
                        ->select('diagrams.path AS diagram',
                                 'q_tables.options AS option',
                                 'q_tables.difficulty AS difficulty',
                                 'q_tables.category AS category',
                                 'q_tables.time AS time',
                                 'q_descriptions.description AS description',
                                 'equations.exp_latex AS equation',
                                 'codes.code_description AS code',
                                 'q_tables.q_id AS question_id',
                                 'equations.exp_id AS exp_id',
                        		 'codes.code_id AS code_id',
                                 'q_tables.tag_revision AS tag_revision')->first();


        /****************Update description*****************************/

        $description = Request::get('Q_desc');

        $changed_flag = 0;

        if(strcmp($description, $question->description)!==0){
        	$q_description = new q_description();

            $q_description->description = Request::get('Q_desc');
            $description_image_URL = Request::get('hidden_desc_url');
            $name = 'question'.$date.$time.'.png';
            $path = storage_path().'/images/Question/'.$name;
            file_put_contents($path, file_get_contents($description_image_URL));

            $path = URL::to('/').'/images/'.$name;
            $q_description->image_path = $path;

            $q_description->save();
            $description_id = $q_description->getKey();

        	DB::table('q_tables')
        		->where('q_id',$question->question_id)
        		->update(['description_id'=>$description_id]);

        	$changed_flag = 1;
        }


        /*********************Updating options**************************/

       	$answer = Request::get('answer');

        $options_changed = 0;

        $revisions = options::where('q_id',$question_id)->max('revision');

       	$current_option_count = Request::get('no_questions');

        if (!is_null($question->option)) {
            # code...
            $count_initial = options::where('q_id','=',$question->question_id)
                                    ->where('revision',$question->option)
                                    ->count();  

            $descs = DB::table('options')
                        ->where('q_id',$question_id)
                        ->where('revision',$question->option)
                        ->lists('description','option_no');
        }
		else{
            $count_initial = 0;
        }

        if($count_initial===0){
            if($current_option_count!=0){
                $options_changed = 1;
            }
            else{
                //do nothing
            }
        }

        else{
            if($current_option_count == $count_initial){
                for ($i = 1 ; $i <= $current_option_count ; $i++ ) {
                    $name_option = 'member'.$i;
                    $text = Request::get($name_option);
                    if (strcmp($descs[$i],trim($text))!==0) {
                        $options_changed = 1;
                    }
                    else{
                        //do nothing
                    }
                }
            }
            else{
                $options_changed = 1;
            }
        }


        if ($options_changed===1&&!empty($current_option_count)) {
        	
			for ($i = 1 ; $i <= $current_option_count ; $i++ ) {
			 	$name_option = 'member'.$i;
				$text = Request::get($name_option);

				$option = new options();

				$option->q_id = $question_id; //take value from Question table
		        $option->option_no = $i;
		        $option->description = $text;
		        $option->correct_ans = $answer;
                $option->revision = $revisions+1;
		        $option->save();
			}
            DB::table('q_tables')
                    ->where('q_id',$question_id)
                    ->update(['options'=>$revisions+1]);
            $changed_flag = 1;
        }
        elseif ($options_changed===1&&empty($current_option_count)) {
            # code...
            DB::table('q_tables')
                    ->where('q_id',$question_id)
                    ->update(['options'=>null]);
            $changed_flag = 1;
        }
        else{
        	//do nothing
        }

        /********************Updating Equations********************/
        $new_equation = Request::get('Q_exp');

        if(strcmp($new_equation, $question->equation)!==0){
        	$equation = new equations();
	 		
	 		$equation->exp_latex = $new_equation;
	 		
	 		$equation_URL = Request::get('hidden_exp_url');
	        $name = 'equation'.$date.$time.'.gif';
	 		$path = storage_path().'/images/'.$name;
	        file_put_contents($path, file_get_contents($equation_URL));

	        $path = URL::to('/').'/images/'.$name;
	        $equation->exp_image = $path;
	        $equation->save();

	        $eq_id = $equation->getKey();
        	DB::table('q_tables')
        		->where('q_id',$question_id)
        		->update(['exp_id'=>$eq_id]);

        	$changed_flag = 1;
        }


        /*********************Updating Codes************************/
        $code_description = Request::get('Q_code');
 		
 		if (strcmp($code_description, $question->code)!==0) {
			$code = new code();

	 		$code->code_description = $code_description;
	 		
	 		$code_URL = Request::get('hidden_code_url');
	        $name = 'code'.$date.$time.'.png';
	 		$path = storage_path().'/images/'.$name;
	        file_put_contents($path, file_get_contents($code_URL));

	        $path = URL::to('/').'/images/'.$name;
	        $code->code_image_path = $path;


	        $code->save();

	        $code_id = $code->getKey();

			DB::table('q_tables')
        		->where('q_id',$question_id)
        		->update(['exp_id'=>$eq_id]);

        	$changed_flag = 1;
        }

        /*********************updating diagrams*********************/
        $image_removed = Request::get('remove_image');
        if ($image_removed==="0") {
        	# code...
        	if(!empty(Request::file('Q_diagram'))){
		 			if (Request::file('Q_diagram')->isValid()){
		 			$diagram = new diagram();
		            $file = Request::file('Q_diagram');
		            $extension = Request::file('Q_diagram')->getClientOriginalExtension();
		            $name = 'diagram'.$date.$time.'.'.$extension;
		            $path = storage_path().'/images/'.$name;
		            File::copy($file, $path);

		            $path = URL::to('/');
		            $diagram->path = $path.'/images/'.$name;
		            $diagram->save();
		            DB::table('q_tables')
        				->where('q_id',$question->question_id)
        				->update(['diagram_id'=>$diagram->getKey()]);    
        			$changed_flag = 1;
		        }
	    	}

        	else if(!is_null($question->diagram)){
        		DB::table('q_tables')
        			->where('q_id',$question->question_id)
        			->update(['diagram_id'=>null]);
        		$changed_flag = 1;
        	}

        	else{
        		//do nothing
        	}
        }
        else{
        	//do nothing
        }

        /********************Update tags**********************/
        $tags_new = Request::get('tags');

        $current_tag_revision = q_tag_relation::where('q_id',$question_id)->max('tag_revision');        

		$q_tags = q_tag_relation::where('q_id',$question->question_id)
                                ->where('tag_revision',$question->tag_revision)
								->get()
								->lists('tag_id','key')
								->all();
	 	if(sizeof($q_tags)>sizeof($tags_new)){
            $compare = array_diff($q_tags, $tags_new);
        }
		else{
            $compare = array_diff($tags_new, $q_tags);
        }
        Log::info('check tags 1'.print_r($tags_new,true));
        Log::info('check tags 2'.print_r($q_tags,true));
        Log::info('check tags 3'.print_r($compare,true));

		if(empty($compare)){
			//do nothing
		}

		else{
			foreach(Request::get('tags') as $selected_tag){
		        $tag_R = new q_tag_relation();

		        $tag_R->q_id = $question_id;
		        $tag_R->tag_id = $selected_tag;
                $tag_R->tag_revision = $current_tag_revision+1;

		    	$tag_R -> save();
        	}

            DB::table('q_tables')
                    ->where('q_id',$question_id)
                    ->update(['tag_revision'=>$current_tag_revision+1]);

		}

		/***********************Update difficuty************************/
        $new_difficulty = Request::get('difficulty');

        if ($new_difficulty !== $question->difficulty) {
        	# code...
        	DB::table('q_tables')
        			->where('q_id',$question->question_id)
        			->update(['difficulty'=>$new_difficulty]);

        	$changed_flag = 1;
        }

        /***********************Update Category************************/
        $new_category = Request::get('category');

        if ($new_category !== $question->category) {
        	# code...
        	DB::table('q_tables')
        			->where('q_id',$question->question_id)
        			->update(['category'=>$new_category]);

        	$changed_flag = 1;
        }

        /*********************Update Time******************************/
        $new_time = Request::get('timeRequired');

        if ($new_time !== $question->time){
        	
        	DB::table('q_tables')->where('q_id',$question->question_id)->update(['time'=>$new_time]);

        	$changed_flag = 1;

        }


        if($changed_flag ===1){

        	DB::table('q_tables')
        			->where('q_id',$question->question_id)
        			->update(['last_edited_by'=>$user]);
        }

        return redirect('testhome/Home');
        /********END*****/
	}
}