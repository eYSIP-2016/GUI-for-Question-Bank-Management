@extends('admin.adminhome')

	@section('browse')
    <head> <h2><i>Browse</i></h2><br></head>


		{!! Form::open(['url'=>'adminhome/Browse']) !!}
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
      {{ Html::linkAction('Auth\AuthController@sendOption','Refresh',['Browse']) }}     
    </div>
  {!! Form::close() !!}
  <hr>
  <div class="results">
    {{$results}} results
  </div>
  @foreach($questions as $question)

    <div class="card" style="border-radius:0px;" >
      <div class="card-block">
        <div class="q_header">
          <ul>
            <li>Difficulty level:<div class=level_and_time>{{ $question->difficulty }}</div></li>
            <li>Expected Solving time:<div class=level_and_time>{{ $question->time }}</div></li>
          </ul>
        </div><br>
        {{ $question->desc }}<br>
        
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

        <div class="card-footer" style="background:white;">
          <div class="row">
            <div class="col-md-10">
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
            
            <div class="col-md-2">
              <button type="button" class="btn btn-default btn-sm" style="float:right;">
                      <span class="glyphicon glyphicon-hand-up"></span> Pick
                  </button>
            </div>
          </div>  
        </div>
        </div>
      </div>
  @endforeach   
  {!! $questions->render() !!}

	@stop