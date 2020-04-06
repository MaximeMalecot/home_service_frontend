<html>
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
      require_once "config.php";
      require_once "requireStripe.php";
			ini_set('display_errors', '1');
			\Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

			if(isset($_GET['session_id']) && $_GET['session_id'] == 'cancel'){
				echo "Votre payement n'a pas pu aboutir, veuillez réessayer ultérieurement";
				exit();
			}
      if(! isset($_SESSION["mail"])){
        echo "pas co<br />";
      }
      else{
				if(isset($_GET['id'])){
	        $req = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
	        $req->execute(array($_GET['id']));
	        $abo = $req->fetch();
					$req2 = $cx->prepare('SELECT * FROM user WHERE mail = ?');
	        $req2->execute(array($_SESSION['mail']));
	        $user = $req2->fetch();
					if($abo != NULL){
					echo "<div class = 'container'>
								<br /><h2>Nous sommes heureux de voir que vous voulez souscrire à un abonnement ! Mais d'abord vérifier bien ses informations :</h2><br />";
					echo "	<div class=\"abos\">
									<h2>Nom : ".$abo['nom']."</h2>
									<h3>Vous aurez un accès illimité ".$abo['temps']."j/7 et de ".$abo['heure_debut']."h à ".$abo['heure_fin']."h !</h3>
									<h3>Vous aurez ".$abo['nb_heure']."h de services/mois gratuites</h3>
									<h5>Coût : ".$abo['cout']."€ TTC / an</h5>";

						if($abo['stripe_id'] == NULL){
							$newprod = \Stripe\Product::create([
								    'name' => $abo['nom'],
								    'type' => 'service',
							]);
							$req1= $cx->prepare('UPDATE abonnement SET stripe_id = ? WHERE id_abonnement = ?');
							$req1->execute(array($newprod->id, $abo['id_abonnement']));


							$idplan = "0";
							$allPLan = \Stripe\Plan::all();
							foreach ($allPLan as $plan) {
								if($plan->product == $newprod->id){
									$idplan = $plan->id;
									break;
								}
							}
							$cout = intval( ($abo['cout'] * 100)/12 );
							if($idplan == "0"){
								$plan = \Stripe\Plan::create([
								    'currency' => 'eur',
								    'interval' => 'month',
								    'product' => $newprod->id,
								    'nickname' => $abo['nom'],
								    'amount' => $cout,
								]);
								$idplan = $plan->id;
							}
						}
						else{
							$idplan = "0";
							$allPLan = \Stripe\Plan::all();

							foreach ($allPLan as $plan) {
								if($plan->product == $abo['stripe_id']){
									$idplan = $plan->id;
									break;
								}
							}
							$cout = intval( ($abo['cout'] * 100)/12 );
							if($idplan == "0"){
								$plan = \Stripe\Plan::create([
								    'currency' => 'eur',
								    'interval' => 'month',
								    'product' => $abo['stripe_id'],
								    'nickname' => $abo['nom'],
								    'amount' => $cout,
								]);
							}
						}
						$session = \Stripe\Checkout\Session::create([
							'customer'=> $user['stripe_id'],
						  'payment_method_types' => ['card'],
						  'subscription_data' => [
						    'items' => [[
						      'plan' => $idplan,
						    ]],
						  ],
						  'success_url' => URL."/verif_payement.php?session_id={CHECKOUT_SESSION_ID}&abonnement=".$abo['id_abonnement'],
						  'cancel_url' => URL."/abonnement_information.php?session_id=cancel",
						]);
						echo "<button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>
									</div></div>";
					}
					else{
						echo "<div class=\"container\">
										<h1 id=\"congratz\">Une erreur est servenue au niveau de l'abonnement !</h1>
									</div>";
					}
				}
			}
      ?>

  </main>
  <?php
    include('footer.php');
  ?>
	<script type="text/javascript" src="js/script.js"></script>
</body>
</html>
