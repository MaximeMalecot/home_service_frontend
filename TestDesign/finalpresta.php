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

			if(isset($_GET['session_id']) && isset($_GET['date_debut']) && isset($_GET['date_fin']) && isset($_GET['supplement']) && isset($_GET['user']) && isset($_GET['user_ville']) && isset($_GET['prestation'])){
        $req=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,supplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES (DATE(?),DATE(?),?,?,?,?,?)');
        $req->execute(array($_GET['date_debut'],$_GET['date_fin'],$_GET['supplement'],$_GET['user'],$_GET['user_ville'],$_GET['prestation'],$_GET['prestation_ville']));

        $recup=$cx->prepare('SELECT * FROM reservation WHERE user_id_user = ? AND prestation_id_prestation = ?');
        $recup->execute(array($_GET['user'], $_GET['prestation']));
        $reserv = $recup->fetch();
        print_r($reserv);

        $req2=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation) VALUES(NOW(),?,?,?)');
        $req2->execute(array($_GET['cout'],$_GET['user'],$reserv['id_reservation']));
        echo "ah oui";



        /*$req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
        $req->execute(array($_SESSION['mail']));
        $user = $req->fetch();
        $req2 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
        $req2->execute(array($_GET['abonnement']));
        $abo = $req2->fetch();

				$CurrentSession = \Stripe\Checkout\Session::retrieve($_GET['session_id']);

				$req3 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
				$req3->execute(array($user['id_user']));
				$verif = $req3->fetch();

				if($verif == NULL){
					$req5 = $cx->prepare('INSERT INTO souscription(abonnement_id_abonnement,date,heure_restante,user_id_user,user_ville_reference,stripe_id) VALUES(?,NOW(), ?, ?, ?,?)');
					$req5->execute(array($abo['id_abonnement'],$abo['nb_heure'],$user['id_user'],$user['ville_reference'],$CurrentSession['subscription']));
					echo "<div class=\"container\">
									<h1 id=\"congratz\">Félicitations, vous êtes désormais abonné.e et pouvez donc désormais profitez de vos avantages !</h1>
								</div>";
				}
				else{
					$latestsub = \Stripe\Subscription::retrieve($verif['stripe_id']);
					$currentsub = \Stripe\Subscription::retrieve($CurrentSession['subscription']);
					if($currentsub['id'] != $latestsub['id']){
						$latestsub->delete();
						$req4 = $cx->prepare('UPDATE souscription SET abonnement_id_abonnement = ?, date = NOW(), stripe_id = ? WHERE user_id_user = ?');
						$req4->execute(array($abo['id_abonnement'], $CurrentSession['subscription'], $user['id_user']));
						echo "<div class=\"container\">
										<h1 id=\"congratz\">Félicitations pour avoir changer d'abonnement, profitez de vos nouveaux avantages dès maintenant!</h1>
									</div>";
					}
					else{
						echo "<div class=\"container\">
										<h1 id=\"congratz\">Une erreur est servenue, mais ne vous inquietez pas votre abonnement est tout de même pris en compte !</h1>
									</div>";
					}
				}*/
      }
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
