@extends('GUI_Q_Bank_Views.User_Acc_Home_Page')
	@section('browse')
	<h1><i>Browse</i></h1><br>

	{!! Form::open(['url'=>'testhome/Browse']) !!}
		<div class="form-group">
			<div class="row">
				<div class="col-md-10">
					{!! Form::text('search_item','',array('placeholder'=>'Search','class'=>'form-control')) !!}
				</div>
				<div class="col-md-2">
					{!! Form::submit('Search',array('class'=>'btn btn-primary')) !!}
					<a href="{{ url('testhome/Browse')}}">
						<h6><span class="glyphicon glyphicon-refresh"></span></h6>
					</a>	
				</div>
			</div>
				
		</div>
	{!! Form::close() !!}
	<hr>
	<div class="results">
		{{$results}} questions
	</div>
	<?php $count=1; ?>
	@foreach($questions as $question)

		<div class="w3-card-4">
			<div class="w3-container"  style="padding:10px;">
				<div class="q_header">
					<ul>
						<li>Category:<div class=level_and_time>{{ $question->category }}</div></li>
						<li>Difficulty level:<div class=level_and_time>{{ $question->difficulty }}</div></li>
						<li>Expected Solving time:<div class=level_and_time>{{ $question->time }}</div></li>
					</ul>
				</div><br>
				<?php $descs = explode("\n", $question->desc)?>  
				@foreach($descs as $desc)
					{{$desc}}<br>
				@endforeach<br>
				
				<div class="image_list">
					<ul>
					@if(!is_null($question->diagram) && !empty($question->diagram))
						<?php 
							$first = '<li><img src="';
							$last = '"></li>';
							$diagram = $question->diagram;
						?>
						{!! html_entity_decode($first.$diagram.$last)!!}

					@endif
					@if(!is_null($question->equation) && !empty($question->equation))
						<li><img src="<?php echo $question->equation; ?>"></li>
					@endif
					@if(!is_null($question->code) && !empty($question->code))
						<?php 
							$first = '<li><img src="';
							$last = '"></li>';
							$diagram = $question->code;
						?>
						{!! html_entity_decode($first.$diagram.$last) !!}
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
				<div class="w3-container">
					<div class="row">
					
						<div class="col-md-10">
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
						
						<div class="col-md-2">
							{{ Html::link('/testhome/Browse/Pick/'.$question->question_id,'Pick', array('class'=>'btn btn-default btn-sm','style' => 'float:right')) }}
						</div>

					</div>	
				</div>
   			</div>
   		</div>
   		<br>
   		<?php $count = $count + 1;?>
	@endforeach		
	{!! $questions->render() !!}
@stop