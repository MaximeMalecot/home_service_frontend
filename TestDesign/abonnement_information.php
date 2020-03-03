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
      require_once "Stripe/lib/Stripe.php";
      if(! isset($_SESSION["mail"])){
        echo "pas co<br />";
      }
      else{
        $req = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
        $req->execute(array($_GET['id']));
        $abo = $req->fetch();
        echo $_SESSION['mail'];
        \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
        \Stripe\Stripe::getApiKey();
        $session = \Stripe\Checkout\Session::create([
            "customer_email": $_SESSION['mail'],
            'payment_method_types' => ['card'],
            'line_items' => [[
              'name' => $abo['nom'],
              'description' => 'Abo annuel',
              'amount' => $abo['cout'],
              'currency' => 'eur',
              'quantity' => 1,
              ]],
            'success_url' => URL."/abonnement_information.php?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => URL."/abonnement_information.php?session_id=cancel",
          ]);
      }
      ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
