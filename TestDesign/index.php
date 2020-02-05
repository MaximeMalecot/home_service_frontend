<!DOCTYPE html>
<html>
<head>
	<title>Home Service</title>
	<link rel="stylesheet" type="text/css" href="Style/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="Style/style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include('header.php');
	?>
	<main>
		<div class="container" id="container">
			<ul class="nav nav-tabs" id="tabs">
				<li class="active" ><a id="hometab"data-toggle="tab" href="#home">Home</a></li>
				<li><a id="menu1" data-toggle="tab" href="#menu1" onclick="menu1()">Menu 1</a></li>
				<li><a id="menu2" data-toggle="tab" href="#menu2" onclick="menu2()">Menu 2</a></li>
			</ul>

			<div class="tab-content">
				<div id="home" class="tab-pane fade in active">

				</div>
				<div id="menu1" class="tab-pane fade">

				</div>
				<div id="menu2" class="tab-pane fade">

				</div>
		</div>
		<script type="text/javascript" src="js/script.js"></script>
	</main>
	<?php
		include('footer.php');
	?>
</body>
</html>
