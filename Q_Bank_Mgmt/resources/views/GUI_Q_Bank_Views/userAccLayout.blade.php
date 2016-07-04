<!DOCTYPE html>
<html>
	<head>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="/css/GUI_QBank/UserHomePg.css">
		<title>This is the Home page of a normal user</title>
		<script type="text/javascript">

			$(document).ready(function () {
			      $('#checkBtn').click(function() {
			      checked = $("input[type=checkbox]:checked").length;

			      if(!checked) {
			        alert("Choose at least one tag");
			        return false;
			      }
			    });
			});

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

			function addTextAtCaret(textAreaId, text) {
			    var textArea = document.getElementById(textAreaId);
			    var cursorPosition = textArea.selectionStart;
			    addTextAtCursorPosition(textArea, cursorPosition, text);
			    updateCursorPosition(cursorPosition, text, textArea);
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
		                container.appendChild(document.createTextNode(" Member " + (i+1)));
		                // Create an <input> element, set its type and name attributes
		                var input = document.createElement("input");
		                input.type = "text";
		                input.name = "member" + i;
		                input.required = "required";
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
	<div id="head">
		<ul>
			<li>Username</li>
			<li style="float:right">Signout</li>
		</ul>
	</div>
	<div id="main">
		<div id="left_bar">
			<nav class="navigation">
			<ul class="mainmenu">
				@yield('nav_bar')
			</ul>
			</nav>
		</div>

		<div id="right_bar">
			@yield('view_section')
		</div>
	</div>
</body>
</html>