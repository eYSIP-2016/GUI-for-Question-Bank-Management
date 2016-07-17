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
 		$user = Auth::id();
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
        	$question->options = 1;
        }


        /********Storing question description***********/
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

 		$search_tags = Request::get('tags');

 		$question_from_tags = q_tag_relation::whereIn('tag_id',$search_tags)->lists('q_id');

 		$question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');

 		$option = 'Browse';

 		$tags =  tags::lists('name','id');

 		if(empty($search_string)){
 		    
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
                                 'q_tables.q_id AS question_id',
                                 'reviewer.name AS reviewer')
            			->whereIn('q_tables.q_id',$question_from_tags)->orderBy('q_tables.updated_at','desc');
        }
        else{
        	
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
                                 'reviewer.name AS reviewer')
            			->whereIn('q_tables.q_id',$question_from_tags)
            			->whereIn('q_tables.description_id',$question_from_description)
            			->orderBy('q_tables.updated_at','desc');
        }
        
        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('GUI_Q_Bank_Views.user_acc_browse',compact('option','tags','questions','results'));
 	}

 	public function getUsersQuestions(){
 		$search_string = Request::get('search_item'); 

 		$search_tags = Request::get('tags');

 		$user = '2';

 		$tags =  tags::lists('name','id');

 		$question_from_tags = q_tag_relation::whereIn('tag_id',$search_tags)->lists('q_id');

 		$question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');

 		$option = 'Home';
 		if(empty($search_string)){
 			
            $questions = DB::table('q_tables')
                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
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
                        ->where('q_tables.created_by','=',$user)
            			->whereIn('q_tables.q_id',$question_from_tags)->orderBy('q_tables.updated_at','desc');
        }
        else{
        	
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
                                 'q_tables.q_id AS question_id'
                                 )
            			->whereIn('q_tables.q_id',$question_from_tags)
            			->orWhere('q_tables.description_id',$question_from_description)
            			->where('q_tables.created_by','=',$user)
            			->orderBy('q_tables.updated_at','desc');
        }

        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('GUI_Q_Bank_Views.user_acc_home',compact('option','tags','questions','results'));
 	}

 	public function editOrPickQuestion($action, $question_id){
 		if($action ==="Edit"|| $action==="Pick"){
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
	                                 'q_tables.options AS opt_used')->first();

	        $options_used = $question->opt_used;
	        if ($options_used===1) {

	        	$option_object = options::where('q_id',$question_id)->first();
		        $correct_ans = $option_object->correct_ans;

		        return view('GUI_Q_Bank_Views.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','correct_ans','action'));
	        }
	        else{
	        	return view('GUI_Q_Bank_Views.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','action'));
	        }
	        
    	}
    	else{
    		App::abort(403, 'Unauthorized action.');
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
                        		 'codes.code_id AS code_id')->first();


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

       	$option_no = Request::get('no_questions');

		$count_initial = options::where('q_id','=',$question->question_id)
        				->count();		

		$descs = DB::table('options')
						->where('q_id',$question_id)
						->lists('description','option_no');

		DB::table('options')
					->where('q_id',$question_id)
					->delete();


        if (!empty($option_no)) {
        	
			for ($i = 1 ; $i <= $option_no ; $i++ ) {
			 	$name_option = 'member'.$i;
				$text = Request::get($name_option);

				$option = new options();

				$option->q_id = $question_id;//take value from Question table
		        $option->option_no = $i;
		        $option->description = $text;
		        $option->correct_ans = $answer;
		        $option->save();
		        DB::table('q_tables')
        			->where('q_id',$question_id)
        			->update(['options'=>1]);
		        if($option_no === $count_initial){
			        if (strcmp($descs[$i-1],$text)!==0) {
			        	$changed_flag = 1;
			        }
		    	}
		    	else{
		    		$changed_flag = 1;
		    	}
			}
        }
        else{
        	if(empty($count_initial)||$count_initial===0){
        		//do nothing
        	}
        	else{
        		$changed_flag = 1;
        	}
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
        if ($image_removed===0) {
        	# code...
        	if(is_null($question->diagram)||empty($question->diagram)){
        		//do nothing
        	}

        	else if(!is_null(Request::file('Q_diagram'))){
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
        				->update(['diagram'=>$diagram->getKey()]);    
        			$changed_flag = 1;
		        }
	    	}

        	else if(!empty($question->diagram)){
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
		$q_tags = q_tag_relation::where('q_id',$question->question_id)
								->get()
								->lists('tag_id','key')
								->all();
	 	
		$compare = array_diff($tags_new, $q_tags);

		if(empty($compare) && is_null($compare)){
			//do nothing
		}

		else{
			DB::table('q_tag_relations')
				->where('q_id',$question->question_id)
				->delete();

			foreach(Request::get('tags') as $selected_tag){
		        $tag_R = new q_tag_relation();

		        $tag_R->q_id = $question_id;
		        $tag_R->tag_id = $selected_tag;

		    	$tag_R -> save();
        	}
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