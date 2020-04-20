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
      require_once "Stripe/init.php";
			require_once "functions.php";
      \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
			if(isset($_SESSION['mail']) && isset($_SESSION['reservations']) && !empty($_SESSION['reservations'])){
				try{
					$CurrentSession = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
					$reqReservation=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,nb_unite,id_supplement,nb_unit_suplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES(?,?,?,?,?,?,?,?,?)');
			    $reqFacturation=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation,prestataire_id_prestataire,prestataire_ville) VALUES(NOW(),?,?,?,?,?)');

					foreach ($_SESSION['reservations'] as $res) {
	          $rez = unserialize($res);
						$rdd = DateTime::createFromFormat("Y-m-d H:i:s", $rez->getDateDebut()->format("Y-m-d H:i:s"));
						$rdf = DateTime::createFromFormat("Y-m-d H:i:s", $rez->getDateFin()->format("Y-m-d H:i:s"));
						$rdi = DateTime::createFromFormat("Y-m-d H:i:s", $rez->getDateDebut()->format("Y-m-d H:i:s"));

						$allDays = array();

						while ($rdi <= $rdf){
							array_push($allDays, $rdi->format("Y-m-d"));
							$rdi->modify("+1 day");
						}

						$Query = prepareQuery($allDays, "SELECT * FROM planning WHERE DATE(date_debut) IN (", "DATE", ") AND prestataire_id_prestataire = ?" );
						array_push($allDays, $rez->getPrestataireId());
						$getPlannings = $cx->prepare($Query);
						$getPlannings->execute($allDays);
						$PLannings = $getPlannings->fetchAll();

						$reqUpdatePlan = $cx->prepare('UPDATE planning SET date_debut = ?, date_fin = ? WHERE id_planning = ?');

						foreach($PLannings as $p){
							$dd = new DateTime($p['date_debut']);
							$df = new DateTime($p['date_fin']);
							if( ($rdd->format("H") - $dd->format("H")) < ($df->format("H") - $rdf->format("H")) ){
								$dd->setTime($rdf->format("H"), $rdf->format("i"), $rdf->format("s"));
								$dd->modify("+1 hours");

								$reqUpdatePlan->execute(array(
									$dd->format("Y-m-d H:i:s"),
									$df->format("Y-m-d H:i:s"),
									$p['id_planning']
								));
							}
							else if( ($rdd->format("H") - $dd->format("H")) > ($df->format("H") - $rdf->format("H")) ){
								$df->setTime($rdd->format("H"), $rdd->format("i"), $rdd->format("s"));
								$df->modify("-1 hours");

								$reqUpdatePlan->execute(array(
									$dd->format("Y-m-d H:i:s"),
									$df->format("Y-m-d H:i:s"),
									$p['id_planning']
								));
							}
							else{
								$df->setTime($rdd->format("H"), $rdd->format("i"), $rdd->format("s"));
								$df->modify("-1 hours");

								$reqUpdatePlan->execute(array(
									$dd->format("Y-m-d H:i:s"),
									$df->format("Y-m-d H:i:s"),
									$p['id_planning']
								));
							}
						}

					$reqReservation->execute(array(
							$rez->getDateDebut()->format("Y:m:d H:i:s"),
				      $rez->getDateFin()->format("Y:m:d H:i:s"),
				      $rez->getNbUnit(),
				      $rez->getIdSupplement(),
				      $rez->getNbSupplement(),
				      $rez->getUserIdUser(),
				      $rez->getUserVilleReference(),
				      $rez->getPrestationIdPrestation(),
				      $rez->getPrestationVille()
						));
						$lastId = $cx->lastInsertId();
						$reqFacturation->execute(array(
							$rez->getCout(),
							$rez->getUserIdUser(),
							$lastId,
							$rez->getPrestataireId(),
							$rez->getPrestataireVille()
						));
	        }
					$_SESSION['reservations'] = array();
					header( "refresh:5;url=index.php" );
					echo "<h1>Vos réservations ont bien été prises en compte, merci de votre confiance !</h1>";
					echo "<h2>Retrouvez vos factures dans votre espace client</h2>";
				}
				catch(Exception $e){
					echo "une erreur est survenue!";
				}
		}
		else{
			header( "refresh:5;url=index.php" );
			echo "Une erreur est survenue lors du chargement de votre panier";
		}
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
