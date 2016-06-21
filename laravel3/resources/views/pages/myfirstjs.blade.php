<!DOCTYPE html>
<html>
<head>
	<script type="text/javascript" src="http://latex.codecogs.com/editor3.js">
		//scrt_var=encodeURI(document.getElementByID(testthis).value);
		var scrt_var="%5C%7B";
		var strLink = "https://latex.codecogs.com/gif.download?"+scrt_var;
		document.getElementById("download_link").setAttribute("href",strLink);
		/*function myFunction(exp) {
	    	//var string_to_set=document.getElementByID("text_area_for_equ").value;
	    	document.getElementById("text_area_for_equ").value += exp ;
	    }*/

	    /*
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
		}*/

		function getURIforDownload(){
			var code=document.getElementByID("testthis").value;
			var expURI=encodeURI(code);
			var perm_part="https://latex.codecogs.com/gif.download?";
			document.write(perm_part);
		}
	</script>
	<title>
		page for creating a equation view
	</title>
</head>
<body>
	<textarea name="sample" cols="30" rows="20" id="text_area_for_equ">hello</textarea>
	<br>
	@foreach($symbols as $symbol)
	<?php $var = '<button id="add_char_A" onclick="addTextAtCaret(\''; 
		  $var1='\')">';
		  $var2='</button>';
		  $textArea_id='text_area_for_equ\',\'';
		  $exp=$symbol->exp;?>
	{!!html_entity_decode($var.$textArea_id.$exp.$var1.$exp.$var2)!!}	
	@endforeach

	<textarea id ="testthis" rows="3" cols="40"></textarea>
	<a id="download_link">Link</a>

</body>
</html>