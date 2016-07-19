<!DOCTYPE html>
<html>
	<head>
	<!-- Latest compiled and minified CSS -->
	
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <link rel="stylesheet" href="/css/sol.css">
	  <link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">

	    <style type="text/css">
	  	  body{
			  font-family: Open Sans;
			  margin-bottom: 100px;
	  	  }
	  	  .math_keyboard{
		    width:auto;
		    margin-right: 4px;
		    height: auto;
		    margin-top: 10px;
		    }

		    .taglist{
		    list-style-type: none;
		    padding: 10px;
		    }

		    .tagitem, button{
		    display: inline-block;
		    border-style: solid;
		    border-width: 1.5px;
		    border-color:  #0066ff;
		    background-color: #f2f2f2;
		    color:#1a1a1a;
		    margin-bottom: 4px;
		    padding: 2px;
		    border-radius: 4px;
		    font-size: small;
		    }

		    .question_title{
			  font-size: 15px;
		    }

		    .image_list{
			  list-style-type: none;
		    }

		    .image_list li{
			  display:block;
			  padding: 7px;
		    }

		    .image_list li img{
			  max-height: 350px;
  			max-width: 600px;
		    }

		    .creators{
			  font-size: 10px;
			  color:#3377ff;
			  font-style: italic;
			  margin-left: 10px;
			  padding-bottom: 15px;
		   }

		    .creators ul{
			  list-style-type: none;
			  float:right;
		    }

		    .creators li{
			  display: inline-block;
			  padding-right: 20px;
		    }

		    .q_header{
			  font-size: 12px;
			  color: grey;
			  font-style: italic;
			  margin-left: 10px;
			  padding-bottom: 20px;
		    }

		    .q_header ul{
        list-style-type: none;
        float:right;
        }

       .q_header li{
        display: inline-block;
        padding-right: 20px;
        }

        .level_and_time{
        font-style: bold;
        color:#3377ff;
        }

        .options{
        font-size: 15px;
        }

        .options ol{
        list-style-type: lower-alpha;
        }

        .options li{
        display: block;
        }

        .results{
        font-style : italic;
        color : #8c8c8c;
        font-size: 16px;
        padding-bottom: 20px;
        }

        .actions_buttons {
        font-size: 10px;
        padding-bottom: 0px;
        }

        .actions_buttons ul{
        list-style-type: none;
        float:right;
        }

        .actions_buttons li{
        display: inline-block;
        }

        .indent_left{
        margin-left: 14px;
        height: 100px;
        }
	    </style>


	</head>
  <body class="" ="w3-container"></br></br>

    <!-- ********* Showing current version  *************    -->

    <div class="row">
      <div class="col-sm-2"></div>
      <div class="col-sm-8">
      <div class="w3-card-4" style="border-radius:0px;" ></br></br>
        <header class="w3-container w3-light-grey">
          </br></br><center><h3><i><p>Current Question</p></i></h3></center></br></br>
        </header></br>
        <div class="w3-container">
          <div class="q_header">
            <ul>
              <li>Difficulty level:<div class=level_and_time>{{ $question->difficulty }}</div></li>
              <li>Expected Solving time:<div class=level_and_time>{{ $question->time }}</div></li>
            </ul>
          </div><br>
            Q. {{ $question->desc }}<br>        
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
              <li>Updated By: {{ $question->reviewer }} </li> 
            </ul>
          </div><hr>
          <div class="w3-container" style="background:white;">
            <div class="row">
              <div class="col-md-10">
                <?php 
                    $question_id = $question->q_id;
                    $q_tags = App\q_tag_relation::where('q_id','=',$question_id)
                              ->where('tag_revision',$question->tag_revision)
                              ->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
                              ->lists('tags.name','tags.id');
                ?>
                @foreach($q_tags as $key => $value)
                  <span class="label label-info">{{ $value }}</span>
                @endforeach
              </div>            
            </div>  
          </div></br></br>
        </div>
      </div></br></br>
   



      <center>
        <div class="col-md-6">
          <a href="{{ URL::to('/usershome/History') }}" class="btn btn-info">Back</a>
        </div>
        <div class="col-md-6">
         {{ link_to('usershome/Restore/'.$question->q_id.'/'.$version_no,'Restore',array('class' => 'btn btn-warning') ,$secure =null) }}
        </div>      
      </center></br></br></br>

    <!-- **************  Showing old version ************** -->
        

    
      <div class="w3-card-2" style="border-radius:0px;" ></br></br>
        <header class="w3-container w3-light-grey">
          </br></br><center><h3><i>Version {{$version_no}} of Question</i></h3></center></br></br>
        </header></br>
        <div class="w3-container">
          <div class="q_header">
            <ul>
              <li>Difficulty level:<div class=level_and_time>{{ $difficulty }}</div></li>
              <li>Expected Solving time:<div class=level_and_time>{{ $time }}</div></li>
            </ul>
          </div><br>
            Q. {{ $description }}<br>
        
          <div class="image_list">
            <ul>
              @if(!is_null($diagram) && !empty($diagram))
                <li><img src="<?php echo $question->diagram; ?>"></li>
              @endif
              @if(!is_null($equation) && !empty($equation))
                <li><img src="<?php echo $question->equation; ?>"></li>
              @endif
              @if(!is_null($code) && !empty($code))
                <li><img src="<?php echo $question->code; ?>"></li>
              @endif
            </ul>
          </div>
          @if(!is_null($option))
            <?php
              $options = App\options::where('q_id','=',$question->q_id)
                  ->where('revision',$option)
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
              <li>Updated By: {{ $updated_by }} </li> 
            </ul>
          </div><hr>
          <div class="w3-container" style="background:white;">
            <div class="row">
              <div class="col-md-10">
                <?php 
                  $question_id = $question->q_id;
                  $q_tags = App\q_tag_relation::where('q_id','=',$question_id)
                            ->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
                            ->lists('tags.name','tags.id');
                ?>
                @foreach($q_tags as $key => $value)
                  <span class="label label-info">{{ $value }}</span>
                @endforeach
              </div>            
            </div>  
          </div></br></br>
        </div>
      </div></br></br>
      </div>
      <div class="col-sm-2"></div>
    </div>
  </body>
</html>