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
				echo "<section id=\"subscription_invoice\">Vos payements suite à votre abonnement sur : ".$abonnement['nom']."<br/>";


				$invoices  = \Stripe\Invoice::all();
				foreach($invoices as $invoice){
					if($invoice->subscription == $souscription['stripe_id']){
						echo ($invoice->amount_paid/100)."€ le : ";
						$timestamp = $invoice->created;
						echo gmdate("d-m-Y à H:i:s", $timestamp);
					}
				}
				echo "</section>";
				$_SESSION['panier'] = array();
				array_push($_SESSION['panier'], 0, 1, 2);
				print_r($_SESSION['panier']);
			}
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
