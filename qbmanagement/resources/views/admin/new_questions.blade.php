@extends('admin.adminhome')

	@section('new_questions')
	<h1><i>New Questions<i></h1>
	   
    </br></br>
    <center>
    @if($results != 0)
	    {{ link_to('adminhome/submitforreview', 'Submit For Review',array('class' => 'btn btn-info') ,$secure =null) }}
	@else
	    <h4>No New questions</h4>
	@endif
    </center>
    <hr>
    <div class="results">
    @if($results >= 1)
       {{$results}} New Questions Exists
    @endif   
    </div>
    @foreach($questions as $question)

        <div class="w3-card-4" style="border-radius:0px;" >
            <div class="w3-container" style="padding:20px">
            Alloted to :
            <?php 
                $question_id = $question->q_id; 
                $r_id = App\review::
                        where('reviews.q_id',$question->q_id)
                        ->where('reviews.reviewed',0)
                        ->leftJoin('users' ,'reviews.u_id','=','users.id')
                        ->select('users.name' ,'reviews.alloted','reviews.reviewed','reviews.u_id');
                $r_id = $r_id->get(); 
                $count = 0;      
            ?>

            @foreach($r_id as $r)

                @if($r->alloted == 1)
                   &nbsp  {{ $r->name  }}  &nbsp  
                        @if($count%2 == 0)
                        ,
                        <?php $count++;?>
                        @endif  
                @else
                    @if($count%2 == 0)
                        This question is not alloted
                        <?php $count++;?>
                    @endif 
                @endif
            @endforeach
      </div>
      <div class="w3-container" style="padding:20px">
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
            <li>Updated By: {{ $question->editor }} </li> 
          </ul>
        </div>

        <div class="w3-container" style="padding:20px">
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
            
            
          </div>  
        </div>
       </div>
      </div></br>
  @endforeach   
     {!! $questions->render() !!}
  @stop