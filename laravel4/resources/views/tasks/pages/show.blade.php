@extends('tasks.layout.default')
@section('content')
    <h2>
        {!! link_to_route('projects.show', $project->name, [$project->slug]) !!} -
        {{ $task->name }}
    </h2>
 
    {{ $task->description }}
@stop
