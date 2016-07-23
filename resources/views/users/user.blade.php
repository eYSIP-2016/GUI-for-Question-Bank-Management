@extends('layout.default')
@section('content')
<h2> <center>Welcome User</center></h2>

<div class="container">
        <div class="row">
        <div class="col-md-4" ><h3>{!! link_to_route('testhome', 'Questions', null, array('class' => 'btn btn-info')) !!} </h3></div>
        
@stop