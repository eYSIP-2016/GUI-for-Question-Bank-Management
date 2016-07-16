@extends('GUI_Q_Bank_Views.User_Acc_Home_Page')

	@section('compose')

		<h2><i>Compose</i></h2><br>
			{!! Form::open(['url'=>'testhome/compose','files' => true]) !!}
			<div class="form-group">
			
					{!! Form::label('Q_desc','Description') !!}
				    
				    {!! Form::textarea('Q_desc','',array('rows'=>'10','cols'=>'700','class'=>'form-control','required'=>'required','onkeyup'=>"drawText('Q_desc','desc_preview','canvas_id','question','hidden_desc_url_id')")) !!}
				    
				    {!!  Form::hidden('hidden_desc_url','',array('id'=>'hidden_desc_url_id')) !!}

				</div> 
				<br>

				<img id="desc_preview"><br>
				<canvas id="canvas_id" width="800" hidden></canvas>

				<div style="float:right">
					{!! Form::button('Use symbols', array( 'data-toggle'=>'collapse','data-target'=>'#keyboard','class'=>'btn btn-primary')) !!}
				</div>
				<br><hr style="height:1px;background-color:#bbbbbb;"><br>

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



				{!! Form::label('no_questions','Options') !!}<br>
				<div class="row">
					<div class="col-md-9">
						{!! Form::number('no_questions','',array( 'min'=>'2','max' => '6','id'=>'no_questions','class'=>'form-control')) !!}
					</div>

					<div class="col-md-2">
						{!! Form::button('Make Options', array( 'onClick'=>"makeOptions()",'class'=>'btn btn-primary')) !!}
					</div>

					<div class="col-md-1">
						<a onclick="refresh()" style="float:right">
				        	<span class="glyphicon glyphicon-refresh"></span>
				        </a>
				    </div>
				</div>
				
				<br><br>

				<div id="container">
				</div><br><br>


				<!--LATEX EQUATION EDITOR-->

				{!! Form::label('Q_exp','Mathematical Expressions') !!}
				<div style="float:right">
					{!! Form::button('Add an Equation', array( 'data-toggle'=>'collapse','data-target'=>'#math_exp','class'=>'btn btn-primary')) !!}
				</div>
				{!!  Form::hidden('hidden_exp_url','',array('id'=>'hidden_exp_url_id')) !!}
				<hr style="height:1px;background-color:#bbbbbb;"><br>
				
				<div id="math_exp" class="collapse">
					{!! Form::textarea('Q_exp','',array('rows'=>'10','cols'=>'70','class'=>'form-control','onkeyup'=>"makePreview('Q_exp','previewId','hidden_exp_url_id')")) !!}<br>
					<img src="" width="auto" height="auto" id="previewId"><br><br>
				</div>
				
				
				<!--CODE EDITOR-->

				{!! Form::label('Q_code','Add Code') !!}
				<div style="float:right">
					{!! Form::button('Add Code', array( 'data-toggle'=>'collapse','data-target'=>'#code','class'=>'btn btn-primary')) !!}
				</div>
				{!!  Form::hidden('hidden_code_url','',array('id'=>'hidden_code_url_id')) !!}
				<hr style="height:1px;background-color:#bbbbbb;"><br>

				<div id="code" class="collapse">
					{!! Form::textarea('Q_code','',array('rows'=>'10','cols'=>'700','class'=>'form-control','onkeyup'=>"drawText('Q_code','code_preview','canvas_code_id','code','hidden_code_url_id')",'style'=>'font-family:Courier')) !!}<br>

				<img id="code_preview"><br>
				<canvas id="canvas_code_id" width="600" height="43" hidden></canvas>
				</div>


				{!! Form::label('Q_diagram','Diagram') !!}<br>
				{!! Form::file('Q_diagram','',array('class'=>'form-control')) !!}<br><br>

				

				{!! Form::label('tags[]','Tags') !!}<br>
				{!! Form::select('tags[]',$tags,null,array('id'=>'my-select','multiple'=>'multiple','required'=>'required')) !!}

				<br><br><br>

				<div class="row" style="padding-bottom:100px">

					<div class="col-md-3" style="border-right-style:solid;border-right-color:#bbbbbb;border-right-width:1px;">
						{!! Form::label('difficulty','Difficulty') !!}<br>
						<div class="indent_left">
							{!! Form::radio('difficulty','easy',array('required'=>'required')) !!}Easy<br>
							{!! Form::radio('difficulty','medium') !!}Medium<br>
							{!! Form::radio('difficulty','hard') !!}Hard<br>
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
							{!! Form::radio('category','Quantitative',array('required'=>'required')) !!}Quantitative<br>
							{!! Form::radio('category','Electronics') !!}Electronics<br>
							{!! Form::radio('category','Programming') !!}Programming<br>
						</div>
					</div>

				</div>

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
				
			{!! Form::close() !!}
	@stop