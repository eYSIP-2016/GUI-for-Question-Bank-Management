<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="/css/GUI_QBank/UserHomePg.css">
		<title>This is the Home page of a normal user</title>
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