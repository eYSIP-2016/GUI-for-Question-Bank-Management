@extends('users.usershome')

	@section('compose')

		<h1><i>Compose</i></h1><br>
		<div class="btn-group" style="padding-bottom:20px;">
					<a data-toggle="collapse" data-target="#math_exp" class= "btn btn-default">
						Equation <span class="glyphicon glyphicon-superscript"></span>
					</a>
					<a data-toggle="collapse" data-target="#code" class= "btn btn-default">
						Code <b> {_}</b>
					</a>
					<a data-toggle="collapse" data-target="#diagram_id" class= "btn btn-default">
						Diagram <span class="glyphicon glyphicon-picture"></span>
					</a>
					<a data-toggle="collapse" data-target="#keyboard" class= "btn btn-default">
						Symbols <span class="glyphicon glyphicon-gbp"></span>
					</a>
		</div>
			{!! Form::open(['url'=>'usershome/Compose','files' => true]) !!}
			<div class="form-group">
			
					{!! Form::label('Q_desc','Description') !!}
				    
				    {!! Form::textarea('Q_desc','',array('rows'=>'10','cols'=>'700','class'=>'form-control','required'=>'required','onkeyup'=>"drawText('Q_desc','desc_preview','canvas_id','question','hidden_desc_url_id')")) !!}
				    
				    {!!  Form::hidden('hidden_desc_url','',array('id'=>'hidden_desc_url_id')) !!}

				</div>

				<img id="desc_preview">
				<canvas id="canvas_id" width="800" hidden></canvas>


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



				{!! Form::label('no_questions','Options') !!}<br>
				<div class="row">
					<div class="col-md-9">
						{!! Form::number('no_questions','',array( 'min'=>'2','max' => '6','id'=>'no_questions','class'=>'form-control','onkeyup'=>"makeOptions()",'placeholder'=>'Pick a Number between 2 and 6')) !!}
					</div>

					<div class="col-md-1">
						<a onclick="refresh()" style="float:right">
				        	<span class="glyphicon glyphicon-refresh"></span>
				        </a>
				    </div>
				</div>
				<br>

				<div id="options_container">
				</div><br>


				<!--LATEX EQUATION EDITOR-->
				<div id="math_exp" class="collapse">
				{!! Form::label('Q_exp','Mathematical Expressions') !!}
				{!!  Form::hidden('hidden_exp_url','',array('id'=>'hidden_exp_url_id')) !!}
				
					{!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70','class'=>'form-control','onkeyup'=>"makePreview('Q_exp','previewId','hidden_exp_url_id')")) !!}<br>
					<img src="" width="auto" height="auto" id="previewId"><br><br>
				</div>
				
				
				<!--CODE EDITOR-->

				<div id="code" class="collapse">
					{!! Form::label('Q_code','Add Code') !!}
					{!!  Form::hidden('hidden_code_url','',array('id'=>'hidden_code_url_id')) !!}
					
						{!! Form::textarea('Q_code','',array('rows'=>'10','cols'=>'700','class'=>'form-control','onkeyup'=>"drawText('Q_code','code_preview','canvas_code_id','code','hidden_code_url_id')",'style'=>'font-family:Courier')) !!}<br>

						<img id="code_preview"><br>
						<canvas id="canvas_code_id" width="600" height="43" hidden></canvas>
				</div>


				<div id="diagram_id" class="collapse">
					<!----------Upload Images---------->
					{!! Form::label('Q_diagram','Diagram') !!}

			        	{!! Form::file('Q_diagram',array('class'=>'form-control','onchange'=>'openFile(event)')) !!}
				        {!! Form::hidden('remove_image','',array('id'=>'remove_image')) !!}
				</div>




				{!! Form::label('tags[]','Tags') !!}<br>
				{!! Form::select('tags[]',$tags,null,array('id'=>'my-select','multiple'=>'multiple','required'=>'required')) !!}

				<br><br><br>

				<div class="row" style="padding-bottom:50px">

					<div class="col-md-3" style="border-right-style:solid;border-right-color:#bbbbbb;border-right-width:1px;">
						{!! Form::label('difficulty','Difficulty') !!}<br>	
								{!! Form::radio('difficulty','1',array('required'=>'required','id'=>'easy')) !!}Easy<br>

								{!! Form::radio('difficulty','2',array('id'=>'medium')) !!}Medium<br>

								{!! Form::radio('difficulty','3',array('id'=>'hard')) !!}Hard<br>
					</div>
					<div class="col-md-6" style="border-right-style:solid;border-right-color:#bbbbbb;border-right-width:1px;">
						{!! Form::label('timeRequired','Time Required') !!}<br>
						<div class="indent_left">
							{!!Form::number('timeRequired','',array('required'=>'required','min'=>'30','class'=>'form-control','placeholder'=>'in seconds'))!!}
						</div>
					</div>

					<div class="col-md-3">
						{!! Form::label('category','Pick a Category') !!}<br>
						<div class="indent_left">
							{!! Form::radio('category','1',array('required'=>'required')) !!}Quantitative<br>
							{!! Form::radio('category','2') !!}Electronics<br>
							{!! Form::radio('category','3') !!}Programming<br>
						</div>
					</div>

				</div>
				
				


				<center style="padding-top:50px;">
					<ul style="list-style-type:none;">
						<li style="display:inline;padding:20px;">
							{!! Form::submit('Submit',array('id'=>'checkBtn','class'=>'btn btn-primary')) !!}
						</li>
						<li style="display:inline;padding:20px;">
							{!! Form::reset('Reset',array('class'=>'btn btn-default')) !!}
						</li>
						<li>{!! Form ::button('Preview',array('onclick'=>"makeQuestionPreview()",'class'=>'btn btn-default','data-toggle'=>'modal','data-target'=>'#previewModal'))!!}</li>
					</ul>
				</center>
				
			{!! Form::close() !!}

			<div id="previewModal" class="modal fade" role="dialog">
				  	<div class="modal-dialog modal-lg">
					    <!-- Modal content-->
					    <div class="modal-content">
					      	<div class="modal-header">
					        <button type="button" class="close" data-dismiss="modal">&times;</button>
					    </div>
					    <div class="modal-body">
					        <div class="w3-card-4" style="border-radius:0px;" >
								<div class="w3-container" style="padding:10px;">
									
									<div class="q_header">
										<ul>
											<li>Category:<div class=level_and_time><div id="category_container"></div>
											</div></li>
											<li>Difficulty level:<div class=level_and_time><div id="difficulty_container"></div></div></li>
											<li>Expected Solving time:<div class=level_and_time><div id="time_container"></div></div></li>
										</ul><br>
									</div>

									<div id="description_container"></div>

									<div class="image_list">
										<ul>
											<li><img id="diagram_preview" src="#"></li>
											<li><div id="equation_container"></div></li>
											<li><div id="code_container"></div></li>
										</ul>
									</div>

									<div id="options_list">
										
									</div>
									<hr>
									<div class="w3-container" style="background:white;">
										<div id="tag_container"></div>
									</div>
								</div>
							</div>
					    </div>
					      	<div class="modal-footer">
					        	<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					      	</div>
					    </div>
					</div>
				</div>

	@stop