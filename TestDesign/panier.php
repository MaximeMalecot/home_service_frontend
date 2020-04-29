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
      require_once "Stripe/init.php";
      \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
      ini_set('display_errors', '1');


      echo "<div id=\"totalPrestaPannel\">";
      if(isset($_SESSION['mail']) && !empty($_SESSION['mail']) && isset($_SESSION['reservations']) && !empty($_SESSION['reservations'])){
        $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
        $req->execute(array($_SESSION['mail']));
        $user=$req->fetch();
        $req1 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
        $req1->execute(array($user['id_user']));
        $sous=$req1->fetch();

        $cout = 0;
        $nb_heure = 0;
        if($sous != NULL){
            echo "Il vous reste ".$sous['heure_restante']." heure(s) gratuite(s) grâce à votre abonnement !<br />";
            $req2= $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
						$req3= $cx->prepare('SELECT * FROM bareme WHERE id_bareme = ?');
            $i = 0;
            foreach ($_SESSION['reservations'] as $res) {

              $rez = unserialize($res);
              $cout += $rez->getCout();
              $req2->execute(array($rez->getPrestationIdPrestation()));
              $pres = $req2->fetch();
							$req3->execute(array($pres['bareme_id_bareme']));
							$bareme = $req3->fetch();
					    echo "<div class=\"prestapannel\">
                      <h2>Prestation : ".$pres['nom']."</h1>
                      <h4>".$rez->getNbUnit()." ".$bareme['unite']." pour un prix de : ".$rez->getCout()." €</h2>
                      <h4>Supplement : ".$rez->getNbSupplement()."</h4>";
                      if( $rez->getDateDebut() === $rez->getDateFin() ){
                        echo "<h4>Commence le : ".$rez->getDateDebut()." et finit le : ".$rez->getDateFin()." avec ".$rez->getNbUnit()." ".$bareme['unite']." par jour</h4>";
                        $nbJoursTime = strtotime($rez->getDateFin()) - strtotime($rez->getDateDebut());
                        $nbJours = ($nbJoursTime/86400) + 1;
                        $totH = $nbJours * $rez->getNbUnit();
                      }
                      else{
                        echo "<h4>A lieu le : ".$rez->getDateDebut()->format("Y-m-d")." pendant ".$rez->getNbUnit() * $bareme['time_per_unit']." heure(s) </h4>";
                        $totH = $rez->getNbUnit() * $bareme['time_per_unit'];
                      }
                      if($sous['heure_restante'] >= $totH){
                        echo "<button class=\"btn btn-primary\" onclick=\"deleteHours('".$i."','".$totH."')\">L'avoir gratuitement</button>";
                      }



                    echo "</div>";
                    $i+=1;
            }
            echo "<br /><br />Total : ".$cout." €<br /><br />";
            try{
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
                'cancel_url' => URL."/panier.php?session_id=cancel",
              ]);
              echo "<button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>";
              }
              catch(Exception $e){
                echo "Une erreur est survenue lors de la création du panier !";
                unset($_SESSION['reservations']);
                $_SESSION['reservations'] = array();
              }
          }
        else{

            foreach ($_SESSION['reservations'] as $res) {
              $rez = unserialize($res);
              print_r($rez);
              echo "<br />";
              $cout += $rez->getCout();
              echo $rez->getNbUnit()."<br />";
            }
            echo "Total : ".$cout."<br /><br />";
            try{
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
                'cancel_url' => URL."/panier.php?session_id=cancel",
              ]);
              echo "<button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>";
              }
              catch(Exception $e){
                echo "Une erreur est survenue lors de la création du panier !";
                unset($_SESSION['reservations']);
                $_SESSION['reservations'] = array();
              }
          }
      }
      else{
        echo "Votre panier est vide !";
      }
    ?>
  </main>
	<?php
		include('footer.php');
	?>
</body>
</html>
