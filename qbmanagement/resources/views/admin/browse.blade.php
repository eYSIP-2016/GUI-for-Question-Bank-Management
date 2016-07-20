@extends('admin.adminhome')

	@section('browse')
    <head> <h1><i>Browse</i></h1><br></head>
  
  <div class="results">
    {{$results}} Questions
  </div>
  @foreach($questions as $question)

    <div class="w3-card-4" style="border-radius:0px;" >
      <div class="w3-container"  style="padding:20px">
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

        @if(!is_null($question->option))
          <?php
            $options = App\options::where('q_id','=',$question->q_id)
                ->where('revision',$question->option)
                ->lists('description','option_id');
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
        <div class="w3-container" style="background:white padding:10px";>
          <div class="row">
            <div class="col-md-10">
            <?php 
              $question_id = $question->q_id;
              $q_tags = App\q_tag_relation::
                    where('q_id','=',$question_id)
                    ->where('tag_revision',$question->tag_revision)
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
      </div></br>
  @endforeach

  {!! $questions->render() !!}
@stop