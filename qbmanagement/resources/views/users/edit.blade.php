@extends('layouts.app')

@section('content')

<h1>Edit User</h1> 
{{ Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id))) }} 
{{ csrf_field() }}
<ul> 

    <div class="form-group">
        {{ Form::label('name', 'Name :') }}
        {{ Form::text('name')}}
    </div>
    <div class="form-group">
        {{ Form::label('username', 'Username :') }} 
        {{ Form::text('username') }} 
    </div>
    <div class="form-group">
        {{ Form::label('email', 'E-mail :') }} 
        {{ Form::text('email') }}
    </div>
    <div class="form-group">
        {{ Form::label('password', 'Password :') }} 
        {{ Form::text('password') }} 
    </div>
    <div class="form-group">
        {{ Form::label('version', 'version:') }} 
        {{ Form::number('version') }} 
    </div>
    {{ Form::submit('Update', array('class' => 'btn btn-info')) }} 
        {{ link_to_route('users.index', 'Cancel', $user-> id, array('class' => 'btn')) }} 
     
</ul> 
{{ Form::close() }} 
@if ($errors->any()) 
    <ul> {{ implode('', $errors->all('<li class="error">:message</li>')) }} </ul> 
@endif 
@stop