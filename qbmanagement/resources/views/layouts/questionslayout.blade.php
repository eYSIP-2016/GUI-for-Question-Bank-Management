<!DOCTYPE html>
<html>
	<head>

	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	  <!-- Latest compiled and minified CSS -->
	  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/css/bootstrap-select.min.css">

      <link rel="stylesheet" href="/css/sol.css">

      <script type="text/javascript" src="/css/sol.js"> 
      </script>
	  <!-- Latest compiled and minified JavaScript -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/bootstrap-select.min.js"></script>

	  <!-- (Optional) Latest compiled and minified JavaScript translation files -->
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.10.0/js/i18n/defaults-*.min.js"></script>


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
		<title>This is the Home page of a normal user</title>

		<script type="text/javascript">

			$(function () {
		    	$('#myTab a:last').tab('show')
		  	})

			$(function(){
	        	$('#my-select').searchableOptionList();
	        });


			function wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format) {
                var cars = text.split("\n");
                var ht = cars.length;
                var h = 60+(ht-1)*lineHeight;
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

                for (var ii = 0; ii < cars.length; ii++) {

                    var line = "";
                    var words = cars[ii].split(" ");

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
                    y += lineHeight;
                }
             }

             function drawText(textAreaId,previewId,textcanvas,format) {
                 var canvas = document.getElementById(textcanvas);
                 var context = canvas.getContext("2d");
                 var imageElem = document.getElementById(previewId);

                 context.clearRect(0, 0, 100, 600);

                 var maxWidth = 600;
                 var lineHeight = 16;
                 var x = 10; // (canvas.width - maxWidth) / 2;
                 var y = 10;


                 var text = document.getElementById(textAreaId).value;                

                 wrapText(imageElem, context, text, x, y, maxWidth, lineHeight, format);
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

			function addTextAtCaret(textAreaId, text, previewId, textcanvas,format) {
			    var textArea = document.getElementById(textAreaId);
			    var cursorPosition = textArea.selectionStart;
			    addTextAtCursorPosition(textArea, cursorPosition, text);
			    updateCursorPosition(cursorPosition, text, textArea);
			    drawText(textAreaId,previewId,textcanvas,format);
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

			function makePreview(textAreaId,previewId){
				var latexCode = document.getElementById(textAreaId).value;
				var link="https://latex.codecogs.com/gif.latex?";
				var linkToImage=link.concat("",latexCode.replace("\s+","&nbsp;"));
				document.getElementById(previewId).setAttribute("src",linkToImage);
			} 

			function makeOptions(){
					var number = document.getElementById("no_questions").value;
		            // Container <div> where dynamic content will be placed
			            if(number>1&&number<7){
				        var container = document.getElementById("container");

		            // Clear previous contents of the container
			            while (container.hasChildNodes()) {
			                container.removeChild(container.lastChild);
			            }
		            
		            for (i=0;i<number;i++){
		                // Append a node with a random text
		                container.appendChild(document.createTextNode(" Member" + (i+1)+"  "));
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
		            
		            for (i=0;i<number;i++){
		                // Append a node with a random text
		                container.appendChild(document.createTextNode((i+1) + "."));
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
		        else{
		        	alert("Choose a number first :)");
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
	      <li><a href="{{ url('/logout') }}"><span class="glyphicon glyphicon-log-out"></span> logout</a></li>
	    </ul>
	  </div>
	</nav>

	<div class="container">
		<div class="row">
			<div class="col-md-3">
				<ul class="nav nav-pills nav-stacked faded" >
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