<?php

namespace App\Http\Controllers;

use Request;

use App\Http\Requests;

use Illuminate\Support\Facades\URL;
use App;
use App\User;
use App\q_description;
use DB;
use App\q_table;
use App\q_tag_relation;
use App\code;
use App\equations;
use App\options;
use App\diagram;
use App\revision;
use App\tags;
use App\difficulty;
use File;
use Auth;
use Sofa\Revisionable\Laravel\RevisionableTrait; // trait
use Sofa\Revisionable\Revisionable;
use Redirect;
use Log;
use App\review;


class QuestionController extends Controller 
{
    //
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
        $description_image_URL =/** "https://latex.codecogs.com/gif.latex?int%20x=a+b;";**/Request::get('hidden_desc_url');
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

        DB::table('reviews')->insert([
        ['q_id' => $q_id ,'u_id' => 1],
        ['q_id' => $q_id , 'u_id' => 2]
        ]);


 		

 

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

    	return redirect('usershome/Compose');
 	}



 	public function getSearchResults(){

 		$search_string = Request::get('search_item'); 

 		$search_tags = Request::get('tags');

        $tags = tags::lists('name','id');

 		$question_from_tags = q_tag_relation::whereIn('tag_id',$search_tags)->lists('q_id');

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
                                 'q_tables.tag_revision AS tag_revision',
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
            			->orWhereIn('q_tables.description_id',$question_from_description)
            			->orderBy('q_tables.updated_at','desc');

        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('users.browse',compact('option','tags','questions','results'));
 	}

 	public function getUsersQuestions(){
 		$search_string = Request::get('search_item'); 

 		$search_tags = Request::get('tags');

 		$user = Auth::id();

 		$tags =  tags::lists('name','id');

 		

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
                                 'q_tables.tag_revision AS tag_revision',
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
                                 'q_tables.created_by AS created_by')
                        ->where('created_by','=',$user)
                        ->where(function($query){
                            $search_string = Request::get('search_item');

                            $search_tags = Request::get('tags');
                            
                            $question_from_tags = q_tag_relation::whereIn('tag_id',$search_tags)->lists('q_id');

                            $question_from_description = q_description::where('description','LIKE','%'.$search_string.'%')->lists('description_id');

                            $query->whereIn('q_tables.q_id',$question_from_tags)
                                  ->orWhereIn('q_tables.description_id',$question_from_description);
                        })
                        ->orderBy('q_tables.updated_at','desc');

        	$results = $questions->count();

        	$questions = $questions->paginate(4);

        return view('users.home',compact('option','tags','questions','results'));
 	}


 	public function editOrPickQuestion($action, $question_id){
 		if($action ==="Edit"|| $action==="Pick" || $action==="Modify"){
            $user = Auth::id();
            $creator_id = q_table::where('q_id',$question_id)->value('created_by');

            $reviewer_id1 = review::where('q_id',$question_id)->where('reviewed',0)->orderBy('u_id', 'asc')->select('u_id')->first();       
            $reviewer_id2 = review::where('q_id',$question_id)->where('reviewed',0)->orderBy('u_id', 'desc')->select('u_id')->first();
        
            
            if((strcmp($action,"Edit")==0 && ($user==$creator_id)) || (strcmp($action,"Modify")==0 && ($user==$reviewer_id1->user_id || $user==$reviewer_id2->user_id)) || (strcmp($action,"Pick") ==0))
            {
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
                                     'q_tables.tag_revision AS tag_revision',
	                                 'q_tables.options AS option',
	                                 'q_tables.time AS time',
	                                 'difficulty.name AS difficulty',
	                                 'category.name AS category',
	                                 'q_descriptions.description AS description',
	                                 'equations.exp_latex AS equation',
	                                 'codes.code_description AS code',
	                                 'q_tables.q_id AS question_id',
	                                 'q_tables.options AS opt_used')->first();

            $options =DB::table('options')->where('q_id','=',$question->question_id)
                                        ->where('revision',$question->opt_used)
                                        ->lists('description','option_no');  

            $count_option = count($options);
	        $options_used = $question->opt_used;

	        if (!is_null($options_used)) {

	        	$option_object = options::where('q_id',$question_id)->where('revision',$options_used)->first();
		        $correct_ans = $option_object->correct_ans;

		        return view('users.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','count_option','correct_ans','action','options'));
	        }
	        else{
	        	return view('users.editOrPickView',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','action','count_option','options'));
	        }

        }else{
            if(strcmp($action,"Edit")==0)
                return redirect('usershome/Home');
            elseif(strcmp($action,"Modify")==0)
                return redirect('usershome/Review');
            
        }
	        
    	}

    	else{
    		App::abort(403, 'Unauthorized action.');
    	}
	}

	public function makeChanges($question_id){
		
        $user = Auth::id();
        $action = Request::get('action');
        $creator_id = q_table::where('q_id',$question_id)->value('created_by');
        $reviewer_id1 = review::where('q_id',$question_id)->where('reviewed',0)->orderBy('u_id', 'asc')->select('u_id')->first();       
        $reviewer_id2 = review::where('q_id',$question_id)->where('reviewed',0)->orderBy('u_id', 'desc')->select('u_id')->first();
        if((strcmp($action,"Edit")==0 && ($user==$creator_id)) || (strcmp($action,"Modify")==0 && ($user==$reviewer_id->u_id || $user==$reviewer_id2->u_id))){
        $time = time();
        $date = date("Y-m-d",$time);    
        $question = q_table::find($question_id);
		$questions = DB::table('q_tables')
 						->where('q_tables.q_id','=',$question_id)
                        ->leftJoin('q_descriptions','q_tables.description_id','=','q_descriptions.description_id')
                        ->leftJoin('equations','q_tables.exp_id','=','equations.exp_id')
                        ->leftJoin('codes','q_tables.code_id','=','codes.code_id')
                        ->leftJoin('diagrams','q_tables.diagram_id','=','diagrams.diagram_id')
                        ->select('diagrams.path AS diagram',
                                 'q_tables.options AS option',
                                 'q_tables.tag_revision AS tag_revision',
                                 'q_tables.difficulty AS difficulty',
                                 'q_tables.category AS category',
                                 'q_tables.time AS time',
                                 'q_descriptions.description AS description',
                                 'equations.exp_latex AS equation',
                                 'codes.code_description AS code',
                                 'q_tables.q_id AS question_id',
                                 'equations.exp_id AS exp_id',
                        		 'codes.code_id AS code_id',
                                 'q_tables.version AS version')->first();


        /****************Update description*****************************/

        $description = Request::get('Q_desc');

        $changed_flag = 0;

        if(strcmp($description, $questions->description)!==0){
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
            
            $question->description_id = $description_id ;
    
        	$changed_flag = 1;
        }


        /*********************Updating options**************************/


        $answer = Request::get('answer');

        $options_changed = 0;

        $revisions = options::where('q_id',$question_id)->max('revision');

        $current_option_count = Request::get('no_questions');
        
        if (!is_null($questions->option)) {
            # code...
            $count_initial = options::where('q_id','=',$questions->question_id)
                                    ->where('revision',$questions->option)
                                    ->count('q_id');  

            $descs = DB::table('options')
                        ->where('q_id',$question_id)
                        ->where('revision',$questions->option)
                        ->lists('description','option_no');
        }
        else{

            $count_initial = 0;
        }

         Log::info('Initial: '.$count_initial.'Current: '.$current_option_count);
        
         if($count_initial == 0){
            if($current_option_count != 0)
                {
                    $options_changed = 1;
            }
            else{
                //do nothing
            }
        }else{

          if($current_option_count == $count_initial){

                for ($i = 1 ; $i <= $current_option_count ; $i++ ) {
                    $name_option = 'member'.$i;
                    $text = Request::get($name_option);
                    
                    Log::info($descs);
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


        if ($options_changed===1 && !empty($current_option_count)) {
            
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
            $changed_flag = 1;
            $question->options = $revisions+1;
        }
        elseif($options_changed === 1 &&empty($current_option_count))
        {   
            $changed_flag = 1;
            $question->options = null;         

        }
        else{
            //do nothing
        }

        /********************Updating Equations********************/
        $new_equation = Request::get('Q_exp');
        if(strcmp($new_equation, $questions->equation)!==0){
            if($new_equation != ""){
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
                $question->exp_id = $eq_id;
        	
        	   
            }
            else{
             $question->exp_id = null;
            }

            $changed_flag = 1;   //question changed
        }
         

        /*********************Updating Codes************************/
        $code_description = Request::get('Q_code');
 		if (strcmp($code_description, $questions->code)!==0){
 		    if($new_equation != ""){
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
                $question->code_id = $code_id;
			
        	    
            }
            else{
                $question->code_id = null;
            }
            $changed_flag = 1;
        }
        

        /*********************updating diagrams*********************/
        $image_removed = Request::get('remove_image');
        if ($image_removed==='0') {
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
                    $question->diagram_id = $diagram->getKey();
		               
        			$changed_flag = 1;
		        }
	    	}

        	else if(!is_null($questions->diagram)){
                $question->diagram_id = null;
        		
        		$changed_flag = 1;
        	}

        	else{
        		//do nothing
        	}
        }

        /********************Update tags**********************/
        $tags_new = Request::get('tags');

        $current_tag_revision = q_tag_relation::where('q_id',$question_id)->max('tag_revision');

		$q_tags = q_tag_relation::where('q_id',$question_id)
                                ->where('tag_revision',$question->tag_revision)
								->get()
								->lists('tag_id','key')
								->all();
	 	
        if(sizeof($q_tags)>sizeof($tags_new)){
		    $compare = array_diff( $q_tags,$tags_new);
        }
        else{
            $compare = array_diff($tags_new,$q_tags);
        }

		if(empty($compare)){
			//do nothing
		}
		else{

			foreach(Request::get('tags') as $selected_tag){
		        $tag_R = new q_tag_relation();

		        $tag_R->q_id = $question_id;
		        $tag_R->tag_id = $selected_tag;
                $tag_R->tag_revision = $current_tag_revision + 1;

		    	$tag_R -> save();
        	}
            $question->tag_revision = $current_tag_revision + 1;
            $changed_flag = 1;
            //update tagrevision in qtables
		}

		/***********************Update difficuty************************/
        $new_difficulty = Request::get('difficulty');

        if ($new_difficulty !== $question->difficulty) {
        	# code...
            $question->difficulty = $new_difficulty;
        	
        	$changed_flag = 1;
        }

        /***********************Update Category************************/
        $new_category = Request::get('category');

        if ($new_category !== $question->category) {
        	# code...
            $question->category=$new_category;
        	
        	$changed_flag = 1;
        }

        /*********************Update Time******************************/
        $new_time = Request::get('timeRequired');

        if ($new_time !== $questions->time){
        	$question->time=$new_time ;
        	
        	$changed_flag = 1;

        }


        if($changed_flag ==1){
            $question->last_edited_by=$user;
            $question->version = $question->getRevisionsCountAttribute() + 1;
            $question->save();
            
        }
        elseif($changed_flag ==0)
        {
            $question->disableRevisioning();
        }

        

        
        if(strcmp($action,"Edit")==0)
            return redirect('usershome/Home');
        elseif(strcmp($action,"Modify")==0){

            DB::table('reviews')->where('q_id',$question_id)
            ->where('u_id',$user)
            ->update(['reviewed'=>1]);
            return redirect('usershome/Review');
        }
    }
    else{
        if(strcmp($action,"Edit")==0)
            return redirect('usershome/Home');
        elseif(strcmp($action,"Modify")==0){
            return redirect('usershome/Review');
        }
        /********END*****/
    
	}

}

    
    /*******to show version*******/


    
    public function version($question_id,$version_no){
        //check the question id and fetch all the revisions and if version no matches the version stored in the database retreive all the old values and do the join and display and new values and display the question ..provide the button at the bottom to restore or return back
        $r_question_id = $question_id;
        $r_version_no =$version_no;
        $question_old = q_table::find($question_id);
        $version = $question_old->revisionVersion($version_no-1);
        

        $user = Auth::id();            
        $tags =  tags::lists('name','id');

        $category = DB::table('category')->where('key',$version->new('category'))->value('name');
        $description = DB::table('q_descriptions')->where('description_id',$version->new('description_id'))->value('description');
        $diagram = DB::table('diagrams')->where('diagram_id',$version->new('diagram_id'))->value('path');
        $equation = DB::table('equations')->where('exp_id',$version->new('exp_id'))->value('exp_image');
        $code = DB::table('codes')->where('code_id',$version->new('code_id'))->value('code_image_path');

        $option =$version->new('options');

        $q_tag_relation =$version->new('tag_revision');

        $difficulty = DB::table('difficulty')->where('key',$version->new('difficulty'))->value('name');
        $time = $version->old('time');

        $updated_by = User::where('id',$version->new('last_edited_by'))->value('name');
        
        
        $question = DB::table('q_tables')
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
                                 'q_tables.tag_revision AS tag_revision')
                        ->where('q_tables.q_id',$question_id)
                        ->first();
                        



        return view('users.version',compact('question','category','description','diagram','equation','code','difficulty','time','version_no','updated_by','option','q_tag_relation'));
                
    }



    public function revise($question_id,$version_no){

        $question_old = q_table::find($question_id);         //fetching question
        $version = $question_old->revisionVersion($version_no-1);  //fetching version 

        //storing the values in the question field
        $question_old->category = $version->new('category');  
        $question_old->description_id = $version->new('description_id');
        $question_old->diagram_id =$version->new('diagram_id');
        $question_old->exp_id =$version->new('exp_id');
        $question_old->code_id=$version->new('code_id');    
        $question_old->options=$version->new('options');
        $question_old->tag_revision=$version->new('tag_revision');
        $question_old->difficulty=$version->new('difficulty');
        $question_old->time=$version->new('time');
        $question_old->version=$version_no;
        $question_old->last_edited_by=$version->new('last_edited_by');
        //updating it in the databaase
        $question_old->disableRevisioning(); //to disable the revision on restore
        $question_old->save();

        return redirect('usershome/History');
    } 


    public function delete($question_id){
        $question = q_table::find($question_id);
        $question->delete();
        return Redirect::back();
    }

    public function reviewed($question_id){
        $review = review::where('q_id',$question_id)
                    ->where('u_id',Auth::id())
                    ->update(['reviewed'=>1]);
        return Redirect::back();
    }


}


