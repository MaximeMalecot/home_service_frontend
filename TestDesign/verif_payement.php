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

      if(isset($_SESSION['mail']) && isset($_GET['session_id']) && isset($_GET['abonnement'])){
        $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
        $req->execute(array($_SESSION['mail']));
        $user = $req->fetch();
        $req2 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
        $req2->execute(array($_GET['abonnement']));
        $abo = $req2->fetch();

        \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

        $events = \Stripe\Event::all([
          'type' => 'checkout.session.completed',
          'created' => [
            // Check for events created in the last 24 hours.
            'gte' => time() - 24 * 60 * 60,
          ],
        ]);

        foreach ($events->autoPagingIterator() as $event) {
          $session = $event->data->object['id'];
          if( $session == $_GET['session_id'] ){
            $req3 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
            $req3->execute(array($user['id_user']));
            $verif = $req3->fetch();
            if($verif != NULL){
              $req4 = $cx->prepare('UPDATE souscription SET abonnement_id_abonnement = ?, date = NOW() WHERE user_id_user = ?');
              $req4->execute(array($abo['id_abonnement'], $user['id_user']));

              echo "<div class=\"container\">
                      <h1 id=\"congratz\">Félicitations pour avoir changer d'abonnement, profitez de vos nouveaux avantages dès maintenant!</h1>
                    </div>";
            }
            else{
              $req5 = $cx->prepare('INSERT INTO souscription(abonnement_id_abonnement,date,heure_restante,user_id_user,user_ville_reference) VALUES(?,NOW(), ?, ?, ?)');
              $req5->execute(array($abo['id_abonnement'],$abo['nb_heure'],$user['id_user'],$user['ville_reference']));

              echo "<div class=\"container\">
                      <h1 id=\"congratz\">Félicitations, vous êtes désormais abonné.e et pouvez donc désormais profitez de vos avantages !</h1>
                    </div>";
            }
          }
        }
      }
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
