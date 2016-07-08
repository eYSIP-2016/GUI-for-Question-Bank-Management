<!--not useful anymore-->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome To Question Bank GUI</div>

                <div class="panel-body">
                    {!! link_to('/', 'Browse Questions',  array('class' => 'btn btn-info') ,$secure = null) !!}
                    {!! link_to('login', 'Login',  array('class' => 'btn btn-info') ,$secure = null) !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
