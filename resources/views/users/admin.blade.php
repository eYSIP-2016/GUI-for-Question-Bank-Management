@extends('layout.default')
@section('content')
<h2> <center>Welcome Admin</center></h2>

<div class="container">
        <div class="row">
        <div class="col-md-4" ><h3>{!! link_to_route('testhome', 'QB', null, array('class' => 'btn btn-info')) !!} </h3></div>
        <div class="col-md-4"><h3>{!! link_to_route('users.index', 'Users', null, array('class' => 'btn btn-danger')) !!} </h3></div>

@stop