<?php
  require_once "Class/Reservation.php";
  require_once "config.php";

  require_once "requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  if(isset($_POST['heure']) && !empty($_POST['heure'])){
    $heure = $_POST['heure'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if(isset($_POST['date_debut']) && !empty($_POST['date_debut'])){
    $date_debut = $_POST['date_debut'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if($_POST['type'] == 2){
    if(isset($_POST['date_fin']) && !empty($_POST['date_fin'])){
      $date_fin = $_POST['date_fin'];
    }
    else{
      echo "Tous les champs n'était pas remplis";
      die();
    }
  }

  $supplement = $_POST['supplement'];
  if(isset($_SESSION['mail'])){
    $req3 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $req3->execute(array($_POST['id']));
    $prestation = $req3->fetch();

    if($_POST['type'] != 2){
      $date_fin = $date_debut;
    }

    $reserv = new Reservation($heure,$date_debut,$date_fin,$supplement,$_SESSION['mail'],$_POST['id']);
    $reserv->setCout($_POST['nom']);
    /*array_push($_SESSION['reservations'], $reserv);
    $_SESSION['actuReserve'] = array();
    array_push($_SESSION['reservations'], $reserv);*/
    /*$reservobjet = json_encode($reserv);
    print_r($reservobjet);
    $finalobj = json_decode($reservobjet);
    print_r($finalobj);*/
/*
    ///////////////////////WORKING/////////////////////////////////
    $session = \Stripe\Checkout\Session::create([
      'customer'=> $reserv->getUSD(),
      'payment_method_types' => ['card'],
      'line_items' => [[
        'name' => $prestation['nom'],
        'description' => $prestation['nom'],
        'amount' => $reserv->getCout() * 100,
        'currency' => 'eur',
        'quantity' => 1,
      ]],
      'success_url' => URL."/finalpresta.php?session_id={CHECKOUT_SESSION_ID}&date_debut=".$date_debut."&date_fin=".$date_fin."&supplement=".$supplement."&user=".$reserv->getUID()."&user_ville=".$reserv->getUVR()."&prestation=".$prestation['id_prestation']."&prestation_ville=".$prestation['categorie_ville']."&cout=".$reserv->getCout(),
      'cancel_url' => URL."/verifcostpresta.php?session_id=cancel",
    ]);*/

    echo "<div>
            <h2>Votre prestation vous couterais : ".$reserv->getCout()." €</h2>
            <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"gototest('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Ajouter au panier</button>
          </div>
          ";
  }
  else{
    echo "connectez vous et vous pourrez réserver !";
  }


?>
<div id="added">

</div>
<script type="text/javascript" src="js/script.js"></script>
