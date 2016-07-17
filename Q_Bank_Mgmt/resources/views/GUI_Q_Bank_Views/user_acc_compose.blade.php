@extends('GUI_Q_Bank_Views.User_Acc_Home_Page')

	@section('compose')

		<h2><i>Compose</i></h2><br>
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
			{!! Form::open(['url'=>'testhome/compose','files' => true]) !!}
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


				{!! Form::label('tags[]','Tags') !!}<br>
				{!! Form::select('tags[]',$tags,null,array('id'=>'my-select','multiple'=>'multiple','required'=>'required')) !!}

				<br><br><br>

				<div class="row" style="padding-bottom:50px">

					<div class="col-md-3" style="border-right-style:solid;border-right-color:#bbbbbb;border-right-width:1px;">
						{!! Form::label('difficulty','Difficulty') !!}<br>	
						<div class="radio-container">					
							<ul>
								<li>
								{!! Form::radio('difficulty','1',array('required'=>'required','id'=>'easy')) !!}
								{!! Form::label('easy','Easy') !!}
								<div class="check"><div class="inside"></div></div>
								</li>

								<li>
								{!! Form::radio('difficulty','2',array('id'=>'medium')) !!}
								{!! Form::label('meddium','Medium') !!}
								<div class="check"><div class="inside"></div></div>
								</li>

								<li>
								{!! Form::radio('difficulty','3',array('id'=>'hard')) !!}
								{!! Form::label('hard','Hard') !!}
								<div class="check"><div class="inside"></div></div>
								</li>
							</ul>
						</div>
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
					</ul>
				</center>
				
			{!! Form::close() !!}
	@stop