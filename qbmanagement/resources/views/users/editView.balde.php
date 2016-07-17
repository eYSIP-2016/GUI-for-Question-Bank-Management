<!DOCTYPE html>
<html>
	<head>
	<!-- Latest compiled and minified CSS -->
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<link rel="stylesheet" href="/css/sol.css">

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- jQuery library -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  
    <script type="text/javascript" src="/javascript/sol.js"></script>


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

	  </style>

		<script type="text/javascript">

			$(function () {
		    	$('#myTab a:last').tab('show')
		  	})

		    $(function() {
		        // initialize sol
		        $('#my-select').searchableOptionList();
		    });

		    function refresh(container_id){

		    	if (container_id === "options_container") {
		    		document.getElementById("no_questions").setAttribute("value","");
		    	}
		    	else{
		    		document.getElementById("remove_image").setAttribute("value","0");
		    		document.getElementById("Q_diagram").disabled = false;
		    	}

		    	var container = document.getElementById(container_id);
		        // Clear previous contents of the container
			    while (container.hasChildNodes()) {
			        container.removeChild(container.lastChild);
			    }
		    }

			function wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format, hiddenID) {
                var lines = text.split("\n");
                var len = text.length;
                var h;
                if(format === "question"){
                	h = 50+(Math.floor(len/74)+lines.length-1)*lineHeight;
                }
                else{
                	h = 50+(Math.floor(len/57)+lines.length-1)*lineHeight;
                }
                
                // /alert(text.length+' '+h);
				context.canvas.setAttribute("height",h);

				if(format === "question"){
                 	context.fillStyle = "#ffffff";
	                context.fillRect(0, 0, 600, 500);

	                y=20;
	                context.font = "17px 'Arial'";
	                context.fillStyle = "#000000";
	             }
	             else{
	             	context.fillStyle = "#b3b3b3";
	                context.fillRect(0, 0, 600, 500);

	                y=20;
	                context.font = "17px 'Courier'";
	                context.fillStyle = "#000000";
	             }

                for (var ii = 0; ii < lines.length; ii++) {

                    var line = "";
                    var words = lines[ii].split(" ");

                    for (var n = 0; n < words.length; n++) {
                        var testLine = line + words[n] + " ";
                        var metrics = context.measureText(testLine);
                        var testWidth = metrics.width;

                        if (testWidth > maxWidth) {
                            context.fillText(line, x, y);
                            line = words[n] + " ";
                            y += lineHeight;
                        }
                        else {
                            line = testLine;
                        }
                    }
                    context.fillText(line, x, y);
                    imageElem.src = context.canvas.toDataURL();
                    document.getElementById(hiddenID).setAttribute("value",imageElem.src);
                    y += lineHeight;
                }
             }

             function drawText(textAreaId,previewId,textcanvas,format,hiddenID) {
                 var canvas = document.getElementById(textcanvas);
                 var context = canvas.getContext("2d");
                 var imageElem = document.getElementById(previewId);

                 context.clearRect(0, 0, 100, 600);

                 var maxWidth = 600;
                 var lineHeight = 16;
                 var x = 10; // (canvas.width - maxWidth) / 2;
                 var y = 10;


                 var text = document.getElementById(textAreaId).value;                
 
                 wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format, hiddenID);
             }

			function openCity(evt, cityName) {
			    var i, tabcontent, tablinks;
			    tabcontent = document.getElementsByClassName("tabcontent");
			    for (i = 0; i < tabcontent.length; i++) {
			        tabcontent[i].style.display = "none";
			    }
			    tablinks = document.getElementsByClassName("tablinks");
			    for (i = 0; i < tablinks.length; i++) {
			        tablinks[i].className = tablinks[i].className.replace(" active", "");
			    }
			    document.getElementById(cityName).style.display = "block";
			    evt.currentTarget.className += " active";
			}

			function addTextAtCaret(textAreaId, text, previewId, textcanvas,format, hiddenID) {
			    var textArea = document.getElementById(textAreaId);
			    var cursorPosition = textArea.selectionStart;
			    addTextAtCursorPosition(textArea, cursorPosition, text);
			    updateCursorPosition(cursorPosition, text, textArea);
			    drawText(textAreaId,previewId,textcanvas,format,hiddenID);
			}
			
			function addTextAtCursorPosition(textArea, cursorPosition, text) {
			    var front = (textArea.value).substring(0, cursorPosition);
			    var back = (textArea.value).substring(cursorPosition, textArea.value.length);
			    textArea.value = front + text + back;
			}
			function updateCursorPosition(cursorPosition, text, textArea) {
			    cursorPosition = cursorPosition + text.length;
			    textArea.selectionStart = cursorPosition;
			    textArea.selectionEnd = cursorPosition;
			    textArea.focus();    
			}

			function makePreview(textAreaId,previewId,hiddenID){
				var latexCode = document.getElementById(textAreaId).value;
				var link="https://latex.codecogs.com/gif.latex?";
				var linkToImage=encodeURI(link.concat("",latexCode.replace("\s+","&nbsp;")));

				document.getElementById(hiddenID).setAttribute("value",linkToImage);
				document.getElementById(previewId).setAttribute("src",linkToImage);
			} 

			function makeOptions(){
					var number = document.getElementById("no_questions").value;
		            // Container <div> where dynamic content will be placed
		            var container = document.getElementById("options_container");
		            while (container.hasChildNodes()) {
			                container.removeChild(container.lastChild);
			            }
			            if(number>1&&number<7){
		            
		            for (i=1;i<=number;i++){
		                // Append a node with a random text
		                container.appendChild(document.createTextNode(" Option " +i+"  "));
		                // Create an <input> element, set its type and name attributes
		                var input = document.createElement("input");
		                input.type = "text";
		                input.name = "member" + i;
		                input.required = "required";
		                input.class = "form-control";
		                container.appendChild(input);
		                // Append a line break 
		                container.appendChild(document.createElement("br"));
		            }

		            container.appendChild(document.createTextNode(" Choose the answer: "));
		            
		            for (i=1;i<=number;i++){
		                // Append a node with a random text
		                container.appendChild(document.createTextNode(i + "."));
		                // Create an <input> element, set its type and name attributes
		                var input = document.createElement("input");
		                input.type = "radio";
		                input.name = "answer";
		                input.value = i;
		                input.required = "required";
		                input.class = "form-control"
		                container.appendChild(input);
		            }
		        }
			}
		</script>
	</head>
<body>
<div class="container-fluid">
<div class="row">

    <div class="col-sm-1" style="background-color:lavender;">
    </div>

    <div class="col-sm-10" style="background-color:white;">
    	<h2><i>Edit</i></h2><br>
			{!! Form::open(['url'=>'/testhome/Home/edit/'.$question->question_id,'files' => true]) !!}
			<div class="form-group">
					
					{!! Form::label('Q_desc','Description') !!}
				    
				    {!! Form::textarea('Q_desc',$question->description,array('rows'=>'10','cols'=>'700','class'=>'form-control','required'=>'required','onkeyup'=>"drawText('Q_desc','desc_preview','canvas_id','question','hidden_desc_url_id')")) !!}
				    
				    {!!  Form::hidden('hidden_desc_url','',array('id'=>'hidden_desc_url_id')) !!}

				<br>

				<img id="desc_preview"><br>
				<canvas id="canvas_id" width="800" hidden></canvas>

				<div style="float:right">
					{!! Form::button('Use symbols', array( 'data-toggle'=>'collapse','data-target'=>'#keyboard','class'=>'btn btn-primary')) !!}
				</div>
				<br><hr style="height:1px;background-color:#666666;"><br>

				<div id="keyboard" class="collapse">
					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  @foreach($symbol_group as $group)
						  <?php
						  	$first='<li class="nav-item"><a href="#';
						  	$second='" class="nav-link" data-toggle="tab" role="tab"  aria-controls="';
						  	$third='">';
						  	$last='</a></li>';
						  ?>
						  {!!html_entity_decode($first.$group->div_id.$second.$group->div_id.$third.$group->group_name.$last)!!}
					  @endforeach
					</ul>

					<div class="tab-content">
						@foreach($symbol_group as $group)
						<?php 
							$first = '<div class="tab-pane" id="';
							$last = '" role="tabpanel">';?>
							{!!html_entity_decode($first.$group->div_id.$last)!!}

							@if($group->div_id==="set_algebra")
								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_1 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>
							@elseif($group->div_id==="calculus")

								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_2 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>

							@elseif($group->div_id==="boolean_algebra")

								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_3 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>

							@elseif($group->div_id==="arithmetic")

								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_4 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>
							@elseif($group->div_id==="geometry")

								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_5 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>

							@else

								<div class="math_keyboard">
								<ul style="list-style-type:none;">
									@foreach($symbols_6 as $symbol)
									<li style="display:inline-block;padding-bottom:2.5px;">
											{!! Form::button($symbol->code, array( 'onclick'=>"addTextAtCaret('Q_desc', $symbol->code,'desc_preview','canvas_id','question')",'class'=>'btn btn-default')) !!}
									</li>
									@endforeach
								</ul>
								</div>

							@endif
						</div>
						@endforeach
					</div>
				</div>
				<br><br>



				<?php
					$options = App\options::where('q_id','=',$question->question_id)->lists('description','option_no');

					$count_option = $options->count();
				?>
				{!! Form::label('no_questions','Options') !!}<br>
				{!! Form::number('no_questions',$count_option,array( 'min'=>'2','max' => '6','id'=>'no_questions')) !!}&nbsp&nbsp&nbsp

				{!! Form::button('Make Options', array( 'onClick'=>"makeOptions()",'class'=>'btn btn-primary')) !!}&nbsp&nbsp&nbsp
				<a onclick="refresh('options_container')">
		          	<span class="glyphicon glyphicon-refresh"></span>
		        </a>

				<br><br>

				<div id="options_container">
					
						@foreach($options as $key => $value)
							{!! Form::text('member'.$key, $value); !!}<br>
						@endforeach
						Answer :

						@if($correct_ans==="1")
						{!! Form::radio('answer','1',array('required'=>'required','checked'=>true)) !!}1
						@else
						{!! Form::radio('answer','1',array('required'=>'required')) !!}1
						@endif

						@if($correct_ans==="2")
						{!! Form::radio('answer','2',array('required'=>'required','checked'=>true)) !!}2
						@else
						{!! Form::radio('answer','2') !!}2
						@endif
						
						@if($correct_ans==="3")
						{!! Form::radio('answer','3',array('required'=>'required','checked'=>true)) !!}3
						@else
						{!! Form::radio('answer','3') !!}3
						@endif

						@if($correct_ans==="4")
						{!! Form::radio('answer','4',array('required'=>'required','checked'=>true)) !!}4
						@else
						{!! Form::radio('answer','4') !!}4
						@endif
				</div><br><br>


				<!--LATEX EQUATION EDITOR-->

				{!! Form::label('Q_exp','Mathematical Expressions') !!}
				<div style="float:right">
					{!! Form::button('Add an Equation', array( 'data-toggle'=>'collapse','data-target'=>'#math_exp','class'=>'btn btn-primary')) !!}
				</div>
				{!!  Form::hidden('hidden_exp_url','',array('id'=>'hidden_exp_url_id')) !!}
				<hr style="height:1px;background-color:#666666;"><br>
				
				<div id="math_exp" class="collapse">
					{!! Form::textarea('Q_exp',$question->equation,array('rows'=>'10','cols'=>'70','class'=>'form-control','onkeyup'=>"makePreview('Q_exp','previewId','hidden_exp_url_id')")) !!}<br>
					<img src="" width="auto" height="auto" id="previewId"><br><br>
				</div>
				
				
				<!--CODE EDITOR-->

				{!! Form::label('Q_code','Add Code') !!}
				<div style="float:right">
					{!! Form::button('Add Code', array( 'data-toggle'=>'collapse','data-target'=>'#code','class'=>'btn btn-primary')) !!}
				</div>
				{!!  Form::hidden('hidden_code_url','',array('id'=>'hidden_code_url_id')) !!}
				<hr style="height:1px;background-color:#666666;"><br>

				<div id="code" class="collapse">
					{!! Form::textarea('Q_code',$question->code,array('rows'=>'10','cols'=>'700','class'=>'form-control','onkeyup'=>"drawText('Q_code','code_preview','canvas_code_id','code','hidden_code_url_id')",'style'=>'font-family:Courier')) !!}<br>

					<img id="code_preview"><br>
					<canvas id="canvas_code_id" width="600" height="43" hidden></canvas>
				</div>



				<!----------Upload Images---------->
				{!! Form::label('Q_diagram','Diagram') !!}

		        @if(is_null($question->diagram)||empty($question->diagram))
		        	{!! Form::file('Q_diagram',array('class'=>'form-control')) !!}
			        {!! Form::hidden('remove_image','',array('id'=>'remove_image')) !!}
			    @else
			    	{!! Form::file('Q_diagram',array('disabled'=>'false','class'=>'form-control')) !!}
					<a onclick="refresh('image-container')">
			          	<span class="glyphicon glyphicon-remove-sign">Remove</span>
			        </a>
			    	{!!  Form::hidden('remove_image','1',array('id'=>'remove_image')) !!}
			   	@endif

		        <br><br>

				<div id = "image-container">
					<img src="<?php echo $question->diagram; ?>">
				</div>
				


				<!----choosing tags---->
				<?php 
						$question_id = $question->question_id;
						$q_tags = App\q_tag_relation::where('q_id','=',$question_id)
									->leftJoin('tags','q_tag_relations.tag_id','=','tags.id')
									->lists('tags.id')->all();
				?>
				{!! Form::label('tags[]','Tags') !!}<br>
				{!! Form::select('tags[]',$tags,$q_tags,array('id'=>'my-select','multiple'=>'multiple','required'=>'required')) !!}

				<br><br><br>
				<!---difficulty level---------->
				{!! Form::label('difficulty','Difficulty') !!}<br>
				@if($question->difficulty==="Easy")
				{!! Form::radio('difficulty','Easy',array('required'=>'required','checked'=>true)) !!}Easy
				@else
				{!! Form::radio('difficulty','Easy',array('required'=>'required')) !!}Easy
				@endif

				@if($question->difficulty==="Medium")
				{!! Form::radio('difficulty','Medium',array('required'=>'required','checked'=>true)) !!}Medium
				@else
				{!! Form::radio('difficulty','Medium') !!}medium
				@endif
				
				@if($question->difficulty==="Hard")
				{!! Form::radio('difficulty','Hard',array('required'=>'required','checked'=>true)) !!}Hard
				@else
				{!! Form::radio('difficulty','Hard') !!}Hard
				@endif
				<br><br><br>

				<!-----------------Category tags------------------>
				{!! Form::label('category','Category') !!}<br>
				@if($question->category==="Quantitative")
				{!! Form::radio('category','Quantitative',array('required'=>'required','checked'=>true)) !!}Quantitative
				@else
				{!! Form::radio('category','Quantitative',array('required'=>'required')) !!}Quantitative
				@endif

				@if($question->category==="Electronics")
				{!! Form::radio('category','Electronics',array('required'=>'required','checked'=>true)) !!}Electronics
				@else
				{!! Form::radio('category','Electronics') !!}Electronics
				@endif
				
				@if($question->category==="Programming")
				{!! Form::radio('category','Programming',array('required'=>'required','checked'=>true)) !!}Programming
				@else
				{!! Form::radio('category','Programming') !!}Programming
				@endif
				<br><br><br>


				{!! Form::label('timeRequired','Time Required') !!}<br>
				{!! Form::number('timeRequired',$question->time,array('required'=>'required','min'=>'30')) !!}in seconds<br><br><br>

				<center>
						<ul style="list-style-type:none;">
						<li style="display:inline;padding:20px;">
							{!! Form::submit('Submit',array('id'=>'checkBtn','class'=>'btn btn-primary')) !!}
						</li>
						<li style="display:inline;padding:20px;">
							{!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}
						</li>
						</ul>
				</center>
			</div>
			{!! Form::close() !!}
    </div>

    <div class="col-sm-1" style="background-color:lavender;">
    </div>
</div>
</div>
</body>
</html>
