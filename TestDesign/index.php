<!DOCTYPE html>
<html id="full">
<head>
	<title>Home Service</title>
	<link rel="stylesheet" type="text/css" href="Style/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<link rel="stylesheet" type="text/css" href="Style/style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include('header.php');
	?>
	<main>
		<?php
			if(isset($_SESSION['langue'])){
		    $choice = $_SESSION['langue'];
				$fichier = "xml/".$choice.".xml";
				$xml = simplexml_load_file($fichier);
			}
			else{
				$choice = "fr";
				$fichier = "xml/".$choice.".xml";
				$xml = simplexml_load_file($fichier);
			}
		 ?>
		<section id="fullcontainer">
			<div class="container" id="container">
				<ul class="nav nav-tabs" id="tabs">
					<li class="active" ><a id="hometab"data-toggle="tab" href="#home"><?php echo $xml->main->onglet1; ?></a></li>
					<li><a id="prestationtab" data-toggle="tab" href="#prestation" onclick="prestation()"><?php echo $xml->main->onglet2; ?></a></li>
					<li><a id="abonnementtab" data-toggle="tab" href="#abonnement" onclick="abonnement()"><?php echo $xml->main->onglet3; ?></a></li>
				</ul>

				<div class="tab-content">
					<div id="home" class="tab-pane fade in active">
					</div>
					<div id="prestation" class="tab-pane fade">

					</div>
					<div id="abonnement" class="tab-pane fade">

					</div>
			</div>
		</section>
		<script type="text/javascript" src="js/script.js"></script>
	</main>
	<?php
		include('footer.php');
	?>
</body>
</html>
