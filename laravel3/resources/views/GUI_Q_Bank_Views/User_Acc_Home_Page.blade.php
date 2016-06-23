@extends('pages.userAccLayout')

@section('nav_bar')
	@if($option==="Home"||$option==="")
	<li><a class="active" href="http://localhost/testhome/Home">Home</a></li>
		@section('view_section')
			View My Question Here
		@stop
	@else
	<li><a href="http://localhost/testhome/Home">Home</a></li>
	@endif

	@if($option==="compose")
	<li><a class="active" href="http://localhost/testhome/compose">Compose</a></li>
		@section('view_section')
			Create A form for creating Questions here 
			<form me></form>
		@stop
	@else
	<li><a href="http://localhost/testhome/compose">Compose</a></li>
	@endif

	@if($option==="Review")
	<li><a class="active" href="http://localhost/testhome/Review">Review</a></li>
		@section('view_section')
			Show Review Feed Here
		@stop
	@else
	<li><a href="http://localhost/testhome/Review">Review</a></li>
	@endif

	@if($option==="History")
	<li><a class="active" href="http://localhost/testhome/History">History</a></li>
		@section('view_section')
			Show History here
		@stop	
	@else
	<li><a href="http://localhost/testhome/History">History</a></li>
	@endif

	@if($option==="Browse")
	<li><a class="active" href="http://localhost/testhome/Browse">Browse</a></li>
		@section('view_section')
			Show Browsing Here
		@stop
	@else
	<li><a href="http://localhost/testhome/Browse">Browse</a></li>
	@endif
@stop
