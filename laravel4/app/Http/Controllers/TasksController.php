<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Input;
use Redirect;

class TasksController extends Controller
{
    //
    protected $rules = [
                'name' => ['required','min:3'],
                'slug' => ['required'],
                'description' => ['required'], 
            ];



    public function store(Project $project ,Request $request){

        $this->validate($request, $this->rules);
        $input = Input::all();
        $input['project_id'] = $project->id;
        Task::create( $input );
 
        return Redirect::route('projects.show', $project->slug)->with('message', 'Task created.');
    }


    public function index(Project $project){
    	return view('tasks.pages.index', compact('project'));

    }


    public function create(Project $project){
    	return view('tasks.pages.create', compact('project'));

    }


    public function edit(Project $project, Task $task){
    	return view('tasks.pages.edit', compact('project' , 'task'));

    }


    public function update(Project $project ,Task $task ,Request $request){
        $this->validate($request, $this->rules);
        $input = array_except(Input::all(), '_method');
        $task->update($input);
        return Redirect::route('projects.tasks.show', [$project->slug, $task->slug])->with('message', 'Task updated.');
     
    }


    public function show(Project $project, Task $task){
    	return view('tasks.pages.show', compact('project' ,'task'));

    }


    public function destroy(Project $project , Task $task){
        $task->delete();
        return Redirect::route('projects.show', $project->slug)->with('message', 'Task deleted.');


    }
}
