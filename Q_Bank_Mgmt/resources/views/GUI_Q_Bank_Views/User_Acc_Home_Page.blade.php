@extends('GUI_Q_Bank_Views.userAccLayout')
@section('nav_bar')
	
	<!--This section views the Home page of the user which views his/her questions-->
	@if($option==="Home"||$option==="")
	<li><a class="active" href="http://localhost/testhome/Home">Home</a></li>
		@section('view_section')
			View My Question Here
		@stop
	@else
	<li><a href="http://localhost/testhome/Home">Home</a></li>
	@endif


	<!--This Section Views the compose Question Page-->
	@if($option==="compose")
	<li><a class="active" href="http://localhost/testhome/compose">Compose</a></li>
		@section('view_section')
			<h2 style="color:#737373;font-style:italic;">Create Your Question</h2>
			{!! Form::open() !!}

				{!! Form::label('Q_desc','description') !!}<br>
				{!! Form::textarea('Q_desc','',array('rows'=>'10','cols'=>'70','required'=>'required')) !!}<br><br>
				

				{!! Form::label('Q_exp','Mathematical Expressions') !!}<br>
				{!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70')) !!}<br><br>

				{!! Form::label('Q_diagram','Diagram') !!}<br>
				{!! Form::file('Q_diagram') !!}<br><br>
				<!--<button onclick="makePreview()">Preview</button>-->

				Tags<br>
				<ul class="taglist">
					@foreach($tags as $tag)
						<li class="tagitem">
							{!! Form::checkbox($tag,$tag)!!}{{$tag}}
						</li>
					@endforeach
				</ul>
				<br>
				<center>
					<ul style="list-style-type:none;">
						<li style="display:inline;padding:20px;">
							{!! Form::submit('Submit') !!}
						</li>
						<li style="display:inline;padding:20px;">
							{!! Form::reset('Reset') !!}
						</li>
					</ul>
				</center>
			{!! Form::close() !!}
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
