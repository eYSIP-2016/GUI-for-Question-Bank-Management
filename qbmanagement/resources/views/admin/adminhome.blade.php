@extends('layouts.adminslayout')
@section('nav_bar')
	
	<!--This section views the Home page of the user which views his/her questions-->
	<!--This section views the Home page of the user which views his/her questions-->
	@if($option==="New_questions"||$option==="")
	<li class="active"><a href="{{ URL::to('adminhome/New_questions')}}">New Questions<span class="glyphicon glyphicon-home" style="float:right;"></span></a></li>
		@section('view_section')
			
			@yield('new_questions')

		@stop
	@else
	<li><a href="{{ URL::to('adminhome/New_questions')}}">New Questions<span class="glyphicon glyphicon-home" style="float:right;"></span></a></li>
	@endif


	<!--This Section Views the compose Question Page-->
	@if($option==="Browse")
	<li class="active"><a href="{{ URL::to('adminhome/Browse')}}">Browse<span class="glyphicon glyphicon-pencil" style="float:right;"></span></a></li>
		@section('view_section')

			@yield('browse')
			
		@stop
	@else
	<li><a href="{{ URL::to('adminhome/Browse')}}">Browse<span class="glyphicon glyphicon-pencil" style="float:right;"></span></a></li>
	@endif

	@if($option==="Tags")
	<li class="active"><a href="{{ URL::to('adminhome/Tags')}}">Tags<span class="glyphicon glyphicon-eye-open" style="float:right;"></span></a></li>
		@section('view_section')

			@yield('tags')

		@stop
	@else
	<li><a href="{{ URL::to('adminhome/Tags')}}">Tags<span class="glyphicon glyphicon-eye-open" style="float:right;"></span></a></li>
	@endif

	@if($option==="Users")
	<li class="active"><a href="{{ URL::to('adminhome/Users')}}">Users<span class="glyphicon glyphicon-book" style="float:right;"></span></a></li>
		@section('view_section')
              
			@yield('users')
		
		@stop	
	@else
	<li><a href="{{ URL::to('adminhome/Users')}}">Users<span class="glyphicon glyphicon-book" style="float:right;"></span></a></li>
	@endif

	
@stop


 