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
    <?php
      ini_set('display_errors', 1);
      require_once "config.php";
      require_once "requireStripe.php";
      \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
			if(isset($_SESSION['mail']) && isset($_SESSION['reservations'])){
				try{
					$CurrentSession = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
					$req=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,nb_heure,supplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES (DATE(?),DATE(?),?,?,?,?,?,?)');
					$req1=$cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
					$req2=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation) VALUES(NOW(),?,?,?)');

					foreach ($_SESSION['reservations'] as $res) {
	          $rez = unserialize($res);
						$req1->execute(array($rez->getPID()));
						$PVR = $req1->fetch();
						$req->execute(array(
							$rez->getDateDebut(),
							$rez->getDateFin(),
							$rez->getNbHeure(),
							$rez->getSupplement(),
							$rez->getUID(),
							$rez->getUVR(),
							$rez->getPID(),
							$PVR['categorie_ville']
						));
						$lastId = $cx->lastInsertId();
						$req2->execute(array(
							$rez->getCout(),
							$rez->getUID(),
							$lastId
						));
	        }
					$_SESSION['reservations'] = array();
					echo "<h1>Vos réservations ont bien été prises en compte, merci de votre confiance !</h1>";
				}
				catch(Exception $e){
					echo "une erreur est survenue!";
				}
		}
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
