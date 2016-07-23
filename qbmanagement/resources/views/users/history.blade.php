@extends('users.usershome')
	@section('history')

    <h1><i>History</i></h1><br>
		{!! Form::open(['url'=>'usershome/Browse']) !!}
    <div class="form-group">
      <div class="row">
        <div class="col-md-10">
          {!! Form::text('search_item','',array('placeholder'=>'Search','class'=>'form-control')) !!}
        </div>
        <div class="col-md-2">
          {!! Form::submit('Search',array('class'=>'btn btn-primary','style'=>'width:100%')) !!}
        </div>
      </div>
      <br>
      {!! Form::select('tags[]',$tags,null,array('id'=>'my-select','multiple'=>'multiple')) !!}
      {{ Html::linkAction('NavController@sendOption','Refresh',['Browse']) }}     
    </div>
  {!! Form::close() !!}
  <hr>
  <div class="results">
    {{$results}} results
  </div></br>
  @foreach($questions as $question)
    </br>
    <div class="w3-card-4" style="border-radius:0px;" >
      <div class="w3-container" style="padding:10px">
        <div class="creators">
          <ul>
            <li>Updated By: {{ $question->reviewer }} </li> 
          </ul>
        </div>
      </br>
      <?php
          $revisionquestions=App\q_table::find($question->q_id);
          $count=$revisionquestions->getRevisionsCountAttribute();
        ?>
          Version:
          @for($i=1;$i<=$count;$i++)
            @if($i != $question->version)
              @if($i == 1)
                <?php $h = $i+1; ?>
                {{ link_to('usershome/History/'.$question->q_id.'/'.$h,$i,array('class' => 'label label-primary ') ,$secure =null) }} 
              @else
                {{ link_to('usershome/History/'.$question->q_id.'/'.$i,$i,array('class' => 'label label-primary ') ,$secure =null) }}
              @endif
            @else
               <span class="label label-default">{{$i}}</span>
            @endif
          @endfor
          
      </div><hr>
      <div class="w3-container" style="padding:10px">
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

        
        <hr>
        <div class="w3-container" style="background:white padding:10px";">
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
            
            
          </div>  
        </div>
        </div>
      </div>
  @endforeach   
  {!! $questions->render() !!}

	@stop