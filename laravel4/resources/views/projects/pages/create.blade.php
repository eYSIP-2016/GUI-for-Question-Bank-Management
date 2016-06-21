@extends('projects.layout.default')
@section('content')
    <h2>Create project</h2>
     {!! Form::model(new App\Project, ['route' => ['projects.store']]) !!}
        @include('projects/partials/_form', ['submit_text' => 'Create Project'])
    {!! Form::close() !!}
@stop