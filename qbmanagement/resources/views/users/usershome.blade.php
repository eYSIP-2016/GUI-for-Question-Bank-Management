@extends('layouts.userslayout')
@section('nav_bar')
	
	<!--This section views the Home page of the user which views his/her questions-->
	<!--This section views the Home page of the user which views his/her questions-->
	@if($option==="Home"||$option==="")
	<li class="active"><a href="{{ URL::to('usershome/Home')}}">Home<span class="glyphicon glyphicon-home" style="float:right;"></span></a></li>
		@section('view_section')
			
			@yield('home')

		@stop
	@else
	<li><a href="{{ URL::to('usershome/Home')}}">Home<span class="glyphicon glyphicon-home" style="float:right;"></span></a></li>
	@endif


	<!--This Section Views the compose Question Page-->
	@if($option==="Compose")
	<li class="active"><a href="{{ URL::to('usershome/Compose')}}">Compose<span class="glyphicon glyphicon-pencil" style="float:right;"></span></a></li>
		@section('view_section')

			@yield('compose')
			
		@stop
	@else
	<li><a href="{{ URL::to('usershome/Compose')}}">Compose<span class="glyphicon glyphicon-pencil" style="float:right;"></span></a></li>
	@endif

	@if($option==="Review")
	<li class="active"><a href="{{ URL::to('usershome/Review')}}">Review<span class="glyphicon glyphicon-eye-open" style="float:right;"></span></a></li>
		@section('view_section')

			@yield('review')

		@stop
	@else
	<li><a href="{{ URL::to('usershome/Review')}}">Review<span class="glyphicon glyphicon-eye-open" style="float:right;"></span></a></li>
	@endif

	@if($option==="History")
	<li class="active"><a href="{{ URL::to('usershome/History')}}">History<span class="glyphicon glyphicon-book" style="float:right;"></span></a></li>
		@section('view_section')
              
			@yield('history')
		
		@stop	
	@else
	<li><a href="{{ URL::to('usershome/History')}}">History<span class="glyphicon glyphicon-book" style="float:right;"></span></a></li>
	@endif

	@if($option==="Browse")
	<li class="active"><a href="{{ URL::to('usershome/Browse')}}">Browse<span class="glyphicon glyphicon-search" style="float:right;"></span></a></li>
		@section('view_section')

			@yield('browse')
		
		@stop
	@else
	<li><a href="{{ URL::to('usershome/Browse')}}">Browse<span class="glyphicon glyphicon-search" style="float:right;"></span></a></li>
	@endif
@stop


 