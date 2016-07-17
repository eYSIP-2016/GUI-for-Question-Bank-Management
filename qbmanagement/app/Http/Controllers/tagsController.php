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
    

    protected $rules = [
                'name' => ['required','min:3'],
                ];



    public function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|min:3|unique:tags'
        ]);
    }
    
 
    
    public function index(){

    }

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
        
       // $string = "http://localhost:8000/adminhome/Tags?page=".$tags->lastPage();
        return Redirect::back();
	}
    
    public function destroy(Request $request,$id)
    {    
        //$this->validate($request,$this->rules); 
    //it calls the method delete
        tags::find($id)->delete(); 
                     //fine user with a value in id and delete it from user model
        return Redirect::back();
       
    } 
}
