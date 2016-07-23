<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Input;
use Redirect;
use App\tags;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use Validator;

class tagsController extends Controller
{
    

    //Middleware for the controller

    public function __construct()
    {
        
        $this->middleware('adm');
    }

    //validation rules

    protected $rules = [
                'name' => ['required','min:3'],
                ];



    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|unique:tags'
        ]);
    }
    
 
    
    //Function to store the tags

     public function store(Request $request)
	{

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $input = Input::only('name');
        tags::create($input);
        
        \Session::flash('flash_message','Office successfully deleted');
       
        return redirect('adminhome/Tags')->with('status', 'Tag Added');
	}


    //Function to delete the tags
    
    public function destroy(Request $request,$id)
    {    
    
        tags::find($id)->delete(); 

        \Session::flash('flash_message','Office successfully deleted');
                     //fine user with a value in id and delete it from user model
        return redirect('adminhome/Tags');//->with('status', 'Tag deleted');
       
    } 
}
