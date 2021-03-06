@extends('GUI_Q_Bank_Views.User_Acc_Home_Page')
	@section('home')
	<h1><i>My Questions</i></h1><br>
		{!! Form::open(['url'=>'testhome/Home']) !!}
		<div class="form-group">
			<div class="row">
				<div class="col-md-10">
					{!! Form::text('search_item','',array('placeholder'=>'Search','class'=>'form-control')) !!}
				</div>
				<div class="col-md-2">
					{!! Form::submit('Search',array('class'=>'btn btn-primary','style'=>'width:100%')) !!}
					<a href="{{ url('testhome/Browse')}}">
				<h5><span class="glyphicon glyphicon-refresh"></span></h5>
			</a>	
				</div>
			</div>
		</div>
	{!! Form::close() !!}
	<hr>
  
	<div class="results">
		{{$results}} questions
	</div>

	@foreach($questions as $question)

		<div class="w3-card-4" style="border-radius:0px;" >
			<div class="w3-container" style="padding:10px;">
				<div class="q_header">
					<ul>
						<li>Category:<div class=level_and_time>{{ $question->category }}</div></li>
						<li>Difficulty level:<div class=level_and_time>{{ $question->difficulty }}</div></li>
						<li>Expected Solving time:<div class=level_and_time>{{ $question->time }}</div></li>
					</ul><br>
				</div>
				{{ $question->desc }}<br>
				
				<div class="image_list">
					<ul>
					@if(!is_null($question->diagram) && !empty($question->diagram))
						<li><img src="<?php echo $question->diagram; ?>"></li>
					@endif
					@if(!is_null($question->equation) && !empty($question->equation))
						<li><img src="<?php echo $question->equation; ?>"></li>
					@endif
					@if(!is_null($question->code) && !empty($question->code))
						<li><img src="<?php echo $question->code; ?>"></li>
					@endif
					</ul>
				</div>

				@if(!is_null($question->option))
					<?php
						$options = App\options::where('q_id','=',$question->q_id)->where('revision','=',$question->option)->lists('description','option_id');
					?>

					<ol style="list-style-type:lower-alpha;">
						@foreach($options as $key => $value)
							<li>{{ $value }}</li><br>
						@endforeach
					</ol>

				@endif

				<div class="creators">
					<ul>
						<li>Created By: {{ $question->creator }} </li>
						<li>Updated By: {{ $question->reviewer }} </li>	
					</ul>
				</div>
				<hr>
				<div class="w3-container" style="background:white;">
					<div class="row">
						<div class="col-md-9">
						<?php 
							$q_tags = App\q_tag_relation::
										where('q_id','=',$question->q_id)
										->where('tag_revision','=',$question->tag_revision)
										->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
										->lists('tags.name','tags.id');
						?>
						@foreach($q_tags as $key => $value)
							<span class="label label-info">{{ $value }}</span>
						@endforeach
						</div>
						
						<div class="col-md-3">
							<div class="actions_buttons">
								<ul>
									<li>{{ Html::link('/testhome/Home/Edit/'.$question->question_id,'Edit', array('class'=>'btn btn-primary btn-sm')) }}</li>
									<li>{{ Html::link('/testhome/Home/Pick/'.$question->question_id,'Pick', array('class'=>'btn btn-default btn-sm')) }}</li>
								</ul>
							</div>
						</div>

					</div>	
				</div>
   			</div>
   		</div>
   		<br>
   		<!---Code for modal-->
	@endforeach		
	{!! $questions->render() !!}
	@stop