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

      if(isset($_SESSION['mail'])){
				$req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
				$req->execute(array($_SESSION['mail']));
				$user = $req->fetch();
				$req2 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
				$req2->execute(array($user['id_user']));
				$souscription = $req2->fetch();
				$req3 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
				$req3->execute(array($souscription['abonnement_id_abonnement']));
				$abonnement = $req3->fetch();

				if( strcmp($user['statut'], "admin") == 0){
					echo "<h1>Tu es admin, tu peux donc accéder au BACK-OFFICE ICI : </h1>";
					echo "<form action=\"backoffice.php\">
								    <button class=\"btn btn-primary\">Back Office</button>
								</form>";
				}

				echo "<section id=\"subscription_invoice\">Vos payements suite à votre abonnement sur : ".$abonnement['nom']."<br/>";

				$tes = \Stripe\Subscription::retrieve($souscription['stripe_id']);
				print_r($tes);
				$invoices  = \Stripe\Invoice::all();
				foreach($invoices as $invoice){
					if($invoice->subscription == $souscription['stripe_id']){
						echo "<div>".($invoice->amount_paid/100)."€ le : ";
						$timestamp = $invoice->created;
						echo gmdate("d-m-Y à H:i:s", $timestamp)."</div>";

					}
				}
				echo "</section><br/>";

				$req4 = $cx->prepare('SELECT * FROM reservation WHERE user_id_user = ?	ORDER BY id_reservation DESC');
				$req4->execute(array($user['id_user']));
				$reservations = $req4->fetchAll();
				$req5 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
				$req6 = $cx->prepare('SELECT * FROM facturation WHERE reservation_id_reservation = ?');
				echo "<section id=\"Allreserv\">
								Vos prestations prises : ";
				foreach($reservations as $r){
					$req5->execute(array($r['prestation_id_prestation']));
					$presta = $req5->fetch();
					$req6->execute(array($r['id_reservation']));
					$factu = $req6->fetch();
					echo "<div class=\"histoPresta\">
									Reservation de la prestation :".$presta['nom']."<br/>
									Nombre d'unités :".$r['nb_unite']."<br/>";
									if(strcmp($r['date_debut'], $r['date_fin']) != 0){
										echo "Date de début de la prestation : ".$r['date_debut']."<br/>".
													"Date de fin de la prestation : ".$r['date_fin']."<br/>";
									}
									else{
										echo "Date pour la prestation : ".$r['date_debut']."<br/>";
									}
					echo 		"Cout : ".$factu['cout'];
							if($factu['cout'] > 0){
								echo "<br/><a href=\"facture.php?id=".$factu['id_facturation']."\" class=\"button\">Votre facture</a>";
								}
					echo			"</div>";
				}
				echo "</section>";
			}
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
