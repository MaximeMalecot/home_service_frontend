<!DOCTYPE html>
<html id="full">
<head>
	<title>Home Service</title>
	<link rel="stylesheet" type="text/css" href="Style/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<script type="text/javascript" src="js/script.js"></script>
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
      require_once "Class/Reservation.php";
      require_once "requireStripe.php";
      \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
      ini_set('display_errors', '1');

      $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
      $req->execute(array($_SESSION['mail']));
      $user=$req->fetch();


      $cout = 0;
      if(isset($_SESSION['mail']) && isset($_SESSION['reservations'])){
        foreach ($_SESSION['reservations'] as $res) {
          $rez = unserialize($res);
          $cout += $rez->getCout();
        }
      }
      /*echo "<br /><br />";
      $i = 9;
      $req = $cx->prepare('SELECT * FROM user WHERE id_user = ?');
      while($i<=11){
        $req->execute(array($i));
        $test = $req->fetch();
        print_r($test);
        echo "<br />";
        $i+=1;
      }*/
      echo "Total : ".$cout;

      $session = \Stripe\Checkout\Session::create([
        'customer' => $user['stripe_id'],
        'payment_method_types' => ['card'],
        'line_items' => [[
          'name' => 'Prestations',
          'description' => 'Achat de plusieurs prestations',
          'amount' => $cout * 100,
          'currency' => 'eur',
          'quantity' => 1,
        ]],
        'success_url' => URL."/finalpresta.php?session_id={CHECKOUT_SESSION_ID}",
        'cancel_url' => URL."/verifcostpresta.php?session_id=cancel",
      ]);
      echo "<button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>
            </div></div>";
    ?>
  </main>
	<?php
		include('footer.php');
	?>
</body>
</html>
