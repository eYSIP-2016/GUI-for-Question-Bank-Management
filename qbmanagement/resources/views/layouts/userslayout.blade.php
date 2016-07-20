<!DOCTYPE html>
<html>
	<head>
	<!-- Latest compiled and minified CSS -->
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">

	<link rel="stylesheet" href="/css/sol.css">

	<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">

	<meta charset="utf-8">
	
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- jQuery library -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

	<!-- Latest compiled JavaScript -->

	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  
    <script type="text/javascript" src="/css/sol.js"></script>


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

		.radio-container{
		  display: block;
		  position: absolute;
		  margin: auto;
		  height: auto;
		  background:#222222;
		  width: auto;
		  padding: 0;
		}

		.radio-container ul{
		  list-style: none;
		  height: 100%;
		  width: 100%;
		  margin: 0;
		  padding: 0;
		}


		.radio-container ul li{
		  color: #AAAAAA;
		  display: block;
		  position: relative;
		  float: left;
		  width: 100%;
		  height: 30px;
		  border-bottom: 1px solid #111111;
		}

		.radio-container ul li input[type=radio]{
		  position: absolute;
		  visibility: hidden;
		}

		.radio-container ul li label{
		  display: block;
		  position: relative;
		  font-weight: 300;
		  font-size: 15px;
		  padding: 5px 5px 5px 60px;
		  margin: 0px auto;
		  height: 7px;
		  z-index: 9;
		  cursor: pointer;
		  -webkit-transition: all 0.25s linear;
		}

		.radio-container ul li:hover label{
			color: #FFFFFF;
		}

		.radio-container ul li .check{
		  display: block;
		  position: absolute;
		  border: 1px solid #AAAAAA;
		  border-radius: 100%;
		  height: 25px;
		  width: 25px;
		  top: 3px;
		  left: 2px;
			z-index: 5;
			transition: border .25s linear;
			-webkit-transition: border .25s linear;
		}

		.radio-container ul li:hover .check {
		  border: 5px solid #FFFFFF;
		}

		.radio-container ul li .check::before {
		  display: block;
		  position: absolute;
		  content: '';
		  border-radius: 100%;
		  height: 15px;
		  width: 15px;
		  top: 5px;
		  left: 5px;
		  margin: auto;
		  transition: background 0.25s linear;
		  -webkit-transition: background 0.25s linear;
		}

		.radio-container input[type=radio]:checked ~ .check {
		  border: 5px solid #0DFF92;
		}

		.radio-container input[type=radio]:checked ~ .check::before{
		  background: #0DFF92;
		}

		.radio-container input[type=radio]:checked ~ label{
		  color: #0DFF92;
		}

		

	  </style>
		<title>{{$option}}</title>

		<script type="text/javascript">

			var openFile = function(event) {
			    var input = event.target;

			    var reader = new FileReader();
			    reader.onload = function(){
			      var dataURL = reader.result;
			      var output = document.getElementById('diagram_preview');
			      output.src = dataURL;
			    };
			    reader.readAsDataURL(input.files[0]);
			  };

function makeQuestionPreview(){
				//make category Preview
					var category_container = document.getElementById("category_container");
					// Clear previous contents of the container
				    while (category_container.hasChildNodes()) {
				        category_container.removeChild(category_container.lastChild);
				    }
				   	var category = document.getElementById("category").value;
				   	if (category==="1") {
				   		category_container.appendChild(document.createTextNode("Quantitative"));
				   	}
				   	if (category==="2") {
				   		category_container.appendChild(document.createTextNode("Electronics"));
				   	}
				   	if (category==="3") {
				   		category_container.appendChild(document.createTextNode("Programming"));
				   	}

				//make difficulty Preview
					var difficulty_container = document.getElementById("difficulty_container");
					// Clear previous contents of the container
				    while (difficulty_container.hasChildNodes()) {
				        difficulty_container.removeChild(difficulty_container.lastChild);
				    }
				   	var difficulty = document.getElementById("difficulty").value;
				   	if (difficulty==="1") {
				   		difficulty_container.appendChild(document.createTextNode("Quantitative"));
				   	}
				   	if (difficulty==="2") {
				   		difficulty_container.appendChild(document.createTextNode("Electronics"));
				   	}
				   	if (difficulty==="3") {
				   		difficulty_container.appendChild(document.createTextNode("Programming"));
				   	}

				//make difficulty Preview
					var time_container = document.getElementById("time_container");
					// Clear previous contents of the container
				    while (time_container.hasChildNodes()) {
				        time_container.removeChild(time_container.lastChild);
				    }
				   	var time = document.getElementById("timeRequired").value;
				   	time_container.appendChild(document.createTextNode(time));

				//make description Preview
					var description_container = document.getElementById("description_container");
					// Clear previous contents of the container
				    while (description_container.hasChildNodes()) {
				        description_container.removeChild(description_container.lastChild);
				    }
				   	var description = document.getElementById("Q_desc").value;
				   	description_container.appendChild(document.createTextNode(description));

				//make equation Preview
					var equation_container = document.getElementById("equation_container");
					// Clear previous contents of the container
				    while (equation_container.hasChildNodes()) {
				        equation_container.removeChild(equation_container.lastChild);
				    }
				   	var equation_path = document.getElementById("hidden_exp_url_id").value;
				   	var equation = document.createElement("img");
		                equation.src = equation_path;
				   	equation_container.appendChild(equation);

				//make code Preview
					var code_container = document.getElementById("code_container");
					// Clear previous contents of the container
				    while (code_container.hasChildNodes()) {
				        code_container.removeChild(code_container.lastChild);
				    }
				   	var code_path = document.getElementById("hidden_code_url_id").value;
				   	var code = document.getElementById("Q_code").value;
				   	if (code!=="") {
				   		var code = document.createElement("img");
		                code.src = code_path;
				   		code_container.appendChild(code);
				   	}
				   	

				//make options preview
					var option_text,member_name;
					var number = document.getElementById("no_questions").value;
					var options_container = document.getElementById("options_list");
					while (options_container.hasChildNodes()) {
				        options_container.removeChild(options_container.lastChild);
				    }
					for (i=1;i<=number;i++){
		                // Append a node with a random text
		                member_name = "member"+i;
		                option_text = document.getElementById(member_name).value;
		                options_container.appendChild(document.createTextNode(i+". "+option_text));
		                options_container.appendChild(document.createElement("br"));
		            }

		        //make tags Preview
		        	var tags = []; 
					$("#my-select option:selected").each(function(i, selected){ 
					  tags[i] = $(selected).text(); 
					});
		        	var tag_container = document.getElementById("tag_container");
		        	while (tag_container.hasChildNodes()) {
				        tag_container.removeChild(tag_container.lastChild);
				    }
		        	for (i=0;i<tags.length;i++){
		                // Append a node with a random text
		                var span = document.createElement("span");
		                span.className = "label label-info";
		               	span.appendChild(document.createTextNode(tags[i]));
		               	tag_container.appendChild(span);
				   		tag_container.appendChild(document.createTextNode(" "));

		            }
				}		


			$(function () {
		    	$('#myTab a:last').tab('show')
		  	})

		    $(function() {
		        // initialize sol
		        $('#my-select').searchableOptionList();
		    });

		    window.onload = function() {
				drawText('Q_desc','desc_preview','canvas_id','question','hidden_desc_url_id');
				makePreview('Q_exp','previewId','hidden_exp_url_id');
				drawText('Q_code','code_preview','canvas_code_id','code','hidden_code_url_id');
			};

		    function refresh(){
		    	document.getElementById("no_questions").setAttribute("value","");
		    	var container = document.getElementById("options_container");

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
		                input.id = "member" + i;
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
	
	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <a class="navbar-brand" href="#">{{ Auth::user()->name }}</a>
	    </div>
	    <ul class="nav navbar-nav navbar-right">
	      <li><a href="/logout"><span class="glyphicon glyphicon-log-out"></span> logout</a></li>
	    </ul>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<ul class="nav nav-pills nav-stacked" >
					@yield('nav_bar')
				</ul>
			</div>

			<div class="col-md-9">
				@yield('view_section')
			</div>
		</div>
	</div>
</body>
</html>