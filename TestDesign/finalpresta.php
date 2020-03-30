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
				foreach ($_SESSION['reservations'] as $res){
					$rez = unserialize($res);
					//print_r($rez);
				}
			}
			/*if($CurrentSession = \Stripe\Checkout\Session::retrieve($_GET['session_id'])){
				print_r($CurrentSession);
			}*/
			try{
				$CurrentSession = \Stripe\Checkout\Session::retrieve($_GET['session_id']);
				print_r($CurrentSession);
			}
			catch(Exception $e){
				echo "une erreur est survenue!";
			}
			/*if(isset($_GET['session_id']) && isset($_GET['date_debut']) && isset($_GET['date_fin']) && isset($_GET['supplement']) && isset($_GET['user']) && isset($_GET['user_ville']) && isset($_GET['prestation'])){
        $req=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,supplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES (DATE(?),DATE(?),?,?,?,?,?)');
        $req->execute(array($_GET['date_debut'],$_GET['date_fin'],$_GET['supplement'],$_GET['user'],$_GET['user_ville'],$_GET['prestation'],$_GET['prestation_ville']));

        $recup=$cx->prepare('SELECT * FROM reservation WHERE user_id_user = ? AND prestation_id_prestation = ?');
        $recup->execute(array($_GET['user'], $_GET['prestation']));
        $reserv = $recup->fetch();
        print_r($reserv);

        $req2=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation) VALUES(NOW(),?,?,?)');
        $req2->execute(array($_GET['cout'],$_GET['user'],$reserv['id_reservation']));
        echo "ah oui";

      }*/
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
