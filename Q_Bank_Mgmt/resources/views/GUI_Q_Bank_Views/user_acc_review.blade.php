@extends('GUI_Q_Bank_Views.User_Acc_Home_Page')
	@section('review')
		<h1><i>Review</i></h1><br>
		<hr>

		<div class="w3-card-4">
			<div class="w3-container"  style="padding:10px;">
				<div class="q_header">
					<ul>
						<li>Category:<div class=level_and_time>Quantitative</div></li>
						<li>Difficulty level:<div class=level_and_time>Easy</div></li>
						<li>Expected Solving time:<div class=level_and_time>65</div></li>
					</ul>
				</div><br>

				Question decription here <br>

				<div class="image_list">
					<ul>
						<li><img src="">Put diagram link here use</li>
						<li><img src="">Put equation link here</li>
						<li><img src="">Put code image link here</li>

						Look in the browse file to see how if-else has been used to check whether image is null/empty or not and then print accordingly
					</ul>
				</div>

				<!--check options parameter to see if options are used or not then use a code similar to the one given below
			
				-->
				<ol style="list-style-type:lower-alpha;">
					<li>Option 1</li><br>
					<li>Option 2</li><br>
					<li>Option 3</li><br>
					<li>Option 4</li><br>
				</ol>

				<div class="creators">
					<ul>
						<li>Created By: Creator </li>
						<li>Updated By: Last reviewed or edited by </li>	
					</ul>
				</div>

				<div class="w3-container">
					<div class="row">
					
						<div class="col-md-10">

						<!--
						use similar code for fetching options
						-->
						<span class="label label-info">diffrentiation</span>
						<span class="label label-info">integration</span>

						</div>
						
						<div class="col-md-2">
							{{ Html::link('/testhome/Review/Review/40','review', array('class'=>'btn btn-success btn-sm','style' => 'float:right')) }}
						</div>
						
					</div>	
				</div>

   			</div>
			</div>
		</div>
	@stop