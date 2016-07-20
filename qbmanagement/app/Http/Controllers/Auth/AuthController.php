<?php

namespace App\Http\Controllers\Auth;

//use Venturecraft\Revisionable\RevisionableTrait;
use App\User;
use App\tags;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Auth;
use View;
use Input;
use Redirect;
use Illuminate\Http\Request;
use DB;
use App\q_description;
use App\q_table;
use App\q_tag_relation;
use App\code;
use App\equations;
use App\options;
use File;
use App\revision;




class AuthController extends Controller
{    

    
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected $redirectAfterLogout = '/login';
    

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware($this->guestMiddleware(), ['only' => [
            'login',
            'showLoginForm'
            
        ]]);
        
        $this->middleware('auth', ['except' => [
            'login',
            'showLoginForm'

        ]]);

        $this->middleware('adm', ['except' => [
            'login',
            'showLoginForm',
            'logout'
        ]]);
    }


    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'username' => 'required|max:64|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }


    public function showRegistrationForm()
    {
        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }
        return view('admin.register');
    }





    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->save();
        /**User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);  **/

        //return Auth::user();
    }

    public function postRegister(Request $request)
    {
    // Handle authorization
    $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }
        $this->create($request->all());
        return Redirect::route('adminhome');
    } 


/**
    protected function authenticated()
   {
        if(Auth::user()->user_type_id == 1) {
            return redirect('home');
        }

        return redirect('questions');
    }**/


    protected function index() { 
        //$users = User::all(); 
        $users = User::where('user_type_id', '=', 0)->paginate(10);
        //$users_id = DB::table('users')->where('user_type_id', 0)->lists('id');  //key,column_id
        //shuffle($users_id);
       // $tags = User::find(25)->tags;
       /** $user1=User::find(19);   //right query for user
        $user2=User::where('id',19)->value('version');//right qusery to retrieve value
        $n = $user2 -1;
        $u_id =User::where('user_type_id', '=', 0)->lists('id');
        $revisions = revision::where('u_id',19)->where('version',((int)$user2-1));
        $a = $user1->revisionHistory->where('version',$user2 - 1);    //right query for latest modification
        $history1 = $user1->revisionHistory->where('old_value','bala@gmail.com');
        $a2 = count($revisions);
        $a1 = count($a);
        //$user1->revisionHistory->where('revisionable_id',19)->first()->delete();
        $users1 = User::onlyTrashed()->get();  // to retrieve the soft deleted file
        //$users = DB::table('users')->where('user_type_id', '=', 0)->get();
        
        **/
        //$users = User::paginate(2);
        return view('users.index', compact('users'/**,'tags','users1','a','a1','a2','u_id','revisions','history1','user2')**/));
        //return View::make('user.index', compact('users'));       //this also works just put "use View" on top
    }

    public function edit($id){


        $user = User::find($id);             //find a user from User model(extracted from db) with this id
        if (is_null($user)){                 //if not found return to same page
            return Redirect::route('users.index'); 
        } 
        return view('users.edit', compact('user')); 
    }

    public function update($id){            //method to update a user in user model
        $input = Input::all();  

        // input specifies the values from the web
        // $validation = Validator::make($input, User::$rules); 
        //if ($validation->passes()){ 
            $user = User::find($id);              // it finds the row with $id and stores it in the user variable
            $user->name=Input::get('name'); 
            $user->username=Input::get('username'); 
            $user->email=Input::get('email') ;  
            $user->save();           // update the value stored in database with input values from user values
            return Redirect::route('users.index', $id); 
       // } 
        //return Redirect::route('users.edit', $id) ->withInput() ->withErrors($validation) ->with('message', 'There were validation errors.'); 
    }

    public function destroy($id) {        //it calls the method delete
        User::find($id)->delete();        //fine user with a value in id and delete it from user model
        return Redirect::route('users.index'); 
    } 
    

    protected function sendOption($option){
        if( Auth::check()){
            if($option==="Users"){
                $users = User::where('user_type_id', '=', 0)->paginate(2);
                return view('admin.users',compact('option','users'));
            }
            else if ($option==="Tags") {
                $tags = tags::paginate(10);
                return view('admin.tags',compact('option','tags'));   
            }

            else if ($option==="Browse") {


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


                return view('admin.browse',compact('option','tags','questions','results'));
            }

            else if ($option==="New_questions") {
//displaying new questions in the view                

                $r_q_id = DB::table('reviews')->where('reviewed',0)->distinct()->lists('q_id');
                //$reviews = DB::table('review')->where('reviewed',0)->get();
                $tags =  tags::lists('name','id');

                //fetching new questions created 
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
                                 'reviewer.name AS editor',
                                 'q_tables.q_id AS question_id',
                                 'q_tables.tag_revision AS tag_revision')
                        ->whereIn('q_tables.q_id',$r_q_id)                        
                        ->orderBy('q_tables.updated_at','desc');

                $reviews = DB::table('reviews')
                            ->leftJoin('users AS reviewer','reviews.u_id','=','reviewer.id')
                            ->select('reviews.u_id',
                                     'reviewer.name AS reviewer',
                                     'reviews.q_id',
                                     'reviews.alloted',
                                     'reviews.reviewed')
                            ->where('reviews.reviewed',0);
                                
                $results = $questions->count();
                
                $reviews = $reviews->get();
                $questions = $questions->paginate(4);

                return view('admin.new_questions',compact('option','tags','results','questions','reviews'));
            }
 
            else if ($option==="Home") {
               return view('admin.home',compact('option'));
            }

            else{
                return view('adminhome',compact('option'));     
            }  
        }
    }


    public function distribute(){

        $users = DB::table('users')->where('user_type_id' , 0)->lists('id');  //key,column_id
        $reviews = DB::table('reviews')->where('alloted',0)->distinct()->lists('q_id');
        //$review = DB::table('review')->lists('q_id');
        shuffle($users);
        shuffle($reviews);
        //$shuffled_questions = $questions->shuffle();
        //$shuffled_questions->all();
        $u = count($users);
        $q = count($reviews);
    
        
        
        for($i=0,$j=1,$x=0; $i<$j ; $j++,$i++)   //diagonally  incrementing j,i in upper triangular matrix such that "j<i"
        {
            if($x >= $q){
                break;
            }
            elseif( $j >= $u)
            {  
                if ( $i == 1)   //shuffle order of users to shuffle the pairs after a cycle in upper triangular matrix
                {
                    shuffle($users); 
                }
                
                $j=($j-$i)%($u-1);   //diagonally incrementing j and i in upper triangular 
                $i=-1;
           }
           else {
            
            DB::table('reviews')            
            ->where('q_id',$reviews[$x])
            ->where('u_id',1)   
            ->update(['u_id' => $users[$i] ,'alloted' => 1]);
            // xth question should be alloted to ith reviewer

            DB::table('reviews')            
            ->where('q_id',$reviews[$x])
            ->where('u_id',2)     
            ->update(['u_id' => $users[$j] , 'alloted' => 1]); 

              
            // xth question should be alloted to jth reviewer
            $x++;
            }
        }

        return Redirect::back();
    }



        public function editOrPickQuestion($action, $question_id){
        if($action ==="Edit"|| $action==="Pick" || $action==="Modify"){
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

            $count = count($options);
            $options_used = $question->opt_used;
            if (!is_null($options_used)) {

                $option_object = options::where('q_id',$question_id)->where('revision',$options_used)->first();
                $correct_ans = $option_object->correct_ans;

                return view('admin.edit',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','correct_ans','action','options','count'));
            }
            else{
                return view('admin.edit',compact('question','symbol_group','symbols_1','symbols_2','symbols_3','symbols_4','symbols_5','symbols_6','tags','action'));
            }
            
        }
        else{
            App::abort(403, 'Unauthorized action.');
        }
    }
}
