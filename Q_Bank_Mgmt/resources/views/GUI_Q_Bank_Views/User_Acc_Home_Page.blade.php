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

				{!! Form::label('Q_desc','Description') !!}<br>
				{!! Form::textarea('Q_desc','',array('rows'=>'10','cols'=>'70','required'=>'required')) !!}<br>

				<ul class="tab">
				  @foreach($symbol_group as $group)
					  <?php
					  	$first='<li><a href="#" class="tablinks" onclick="openCity(event, \'';
					  	$second='\')">';
					  	$last='</a></li>';
					  ?>
					  {!!html_entity_decode($first.$group.$second.$group.$last)!!}
				  @endforeach
				</ul>
				@foreach($symbol_group as $group)
					
					<?php 
						$first = '<div id="';
						$last = '" class="tabcontent">';
						?>
					{!!html_entity_decode($first.$group.$last)!!}
					@if($group==="Set Algebra")
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_1 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@elseif($group==="Calculus")
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_2 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@elseif($group==="Boolean Algebra")
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_3 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@elseif($group==="Arithmetic")
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_4 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@elseif($group==="Geometry")
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_5 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@else
						<div class="math_keyboard">
						<ul style="list-style-type:none;">
							@foreach($symbols_6 as $symbol)
							<li style="display:inline-block;">
									{!! Form::button($symbol->code, array( 'onClick'=>"addTextAtCaret('Q_desc', $symbol->code)")) !!}
							</li>
							@endforeach
						</ul>
						</div>
					@endif
					</div>
				@endforeach
				<br><br>
			
				{!! Form::label('no_questions','Options') !!}<br>
				{!! Form::number('no_questions','',array( 'min'=>'2','max' => '6','id'=>'no_questions')) !!}
				{!! Form::button('Make Options', array( 'onClick'=>"makeOptions()")) !!}
				<div id="container">
				</div>

				{!! Form::label('Q_exp','Mathematical Expressions') !!}<br>
				{!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70')) !!}<br>
				{!! Form::button('Make Prevew', array( 'onClick'=>"makePreview('Q_exp','previewId')")) !!}

				<img src="" width="auto" height="auto" id="previewId"><br><br>

				{!! Form::label('Q_diagram','Diagram') !!}<br>
				{!! Form::file('Q_diagram') !!}<br><br>
				<!--<button onclick="makePreview()">Preview</button>-->

				
				{!! Form::label('tag_List','Tags') !!}
				<ul class="taglist">
					@foreach($tags as $tag)
						<li class="tagitem">
							{!! Form::checkbox('tag_List',$tag->name) !!}{{$tag->name}}
						</li>
					@endforeach
				</ul>
				<br>

				{!! Form::label('difficulty','Difficulty') !!}<br>
				{!! Form::radio('difficulty','easy',array('required'=>'required')) !!}Easy
				{!! Form::radio('difficulty','medium') !!}Medium
				{!! Form::radio('difficulty','hard') !!}Hard<br><br>

				{!! Form::label('timeRequired','Time Required',array('required'=>'required')) !!}
				{!!Form::number('timeRequired')!!}<br>

				<center>
					<ul style="list-style-type:none;">
						<li style="display:inline;padding:20px;">
							{!! Form::submit('Submit',array('id'=>'checkBtn')) !!}
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
