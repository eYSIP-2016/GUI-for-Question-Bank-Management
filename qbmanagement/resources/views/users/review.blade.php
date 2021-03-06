@extends('users.usershome')
	@section('review')


		<h1><i>Questions For Review </i></h1><br>
		{!! Form::open(['url'=>'usershome/Review']) !!}
		<div class="form-group">
			<div class="row">
				<div class="col-md-10">
					{!! Form::text('search_item','',array('placeholder'=>'Search','class'=>'form-control')) !!}
				</div>
				<div class="col-md-2">
					{!! Form::submit('Submit',array('class'=>'btn btn-primary','style'=>'width:100%')) !!}
				</div>
			</div>
			<br>
			{!! Form::select('tags[]',$tags,null,array('id'=>'my-select','multiple'=>'multiple')) !!}
			{{ Html::linkAction('NavController@sendOption','Reset',['Home']) }}			
		</div>
	{!! Form::close() !!}
	<hr>
  
	<div class="results">
		@if($results == 0)
		    No Questions for Review
		@else
		    {{$results}} Questions to be reviewed
		@endif
	</div>

	@foreach($review_questions as $question)

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

				@if($question->option=='1')
					<?php
						$options = App\options::where('q_id','=',$question->q_id)->lists('description','option_id');
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
						<div class="col-md-8">
						<?php 
							$question_id = $question->q_id;
							$q_tags = App\q_tag_relation::
										where('q_id','=',$question_id)
										->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
										->lists('tags.name','tags.id');
						?>
						@foreach($q_tags as $key => $value)
							<span class="label label-info">{{ $value }}</span>
						@endforeach
						</div>
						
						<div class="col-md-4">
							<div class="actions_buttons">
								<ul>
									<li>{{ Html::link('/usershome/Review/Modify/'.$question->question_id,'Modify', array('class'=>'btn btn-primary btn-sm')) }}</li>
									<li>{{ Html::link('/usershome/Review/Reviewed/'.$question->question_id,'No Changes', array('class'=>'btn btn-primary btn-sm')) }}</li>
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
	{!! $review_questions->render() !!}
		
	@stop