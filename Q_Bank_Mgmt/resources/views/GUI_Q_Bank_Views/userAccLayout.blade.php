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
			        alert("You must check at least one checkbox.");
			        return false;
			      }
			    });
			});

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