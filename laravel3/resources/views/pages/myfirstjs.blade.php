<!DOCTYPE html>
<html>
<head>
	<script>
		function myFunction(exp) {
	    	//var string_to_set=document.getElementByID("text_area_for_equ").value;
	    	document.getElementById("text_area_for_equ").value += exp ;
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
	<button id="symbol->id" onclick="myFunction('symbol->exp')">symbol->exp</button>	
	@endforeach
	<button id="add_char_A" onclick="myFunction('&part;')">&part;</button>
</body>
</html>