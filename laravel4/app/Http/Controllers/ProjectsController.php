<?php

namespace App\Http\Controllers;

use Input;
use Redirect;
use App\Project;
use App\Task;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class ProjectsController extends  Controller
{
    
    protected $rules = [
                'name' => ['required','min:3'],
                'slug' => ['required'],
                ];

  
    public function index(){

    	$projects = Project::all();
         return view('projects.pages.index', compact('projects'));
    }


    public function create(){ 
	  return view('projects.pages.create');
    }


    public function store(Request $request)
	{
        $this->validate($request, $this->rules);
		$input = Input::all();
        Project::create($input);
        return Redirect::route('projects.index')->with('message','Project Created.');
	}

  
    public function update(Project $project, Request $request)
    {
        $this->validate($request, $this->rules);
        $input = array_except(Input::all(), '_method');
        $project->update($input);
        return Redirect::route('projects.show', $project->slug  )->with('message','Project Updated.');
    }

	
    
    public function show(Project $project)
   {
        return view('projects.pages.show', compact('project'));
   }


    public function edit(Project $project)
    {
    	return view('projects.pages.edit',compact('project'));
    }
    

    public function destroy(Project $project)
    {
    	$project->delete();
        return Redirect::route('projects.index')->with('message', 'Project deleted');
    }
}
