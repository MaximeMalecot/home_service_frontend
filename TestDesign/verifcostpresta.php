<?php
  require_once "config.php";
  require_once "requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  session_start();
  $req = $cx->prepare('SELECT * FROM prestataire WHERE categorie_nom = ?');
  $req->execute(array($_POST['nom']));
  $prestataires = $req->fetchAll();
  ini_set('display_errors', '1');

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


  $cout = 0;
  $id = 0;
  $ville;
  foreach($prestataires as $prestataire){
    if($supplement == 1){
      if( ($prestataire['prix_heure'] + $prestataire['supplement']) > $cout){
        $cout = ($prestataire['prix_heure'] + $prestataire['supplement']);
        $id = $prestataire['id_prestataire'];
        $ville = $prestataire['categorie_ville'];
      }
    }
    else{
      if($prestataire['prix_heure'] > $cout){
        $cout = $prestataire['prix_heure'];
        $id = $prestataire['id_prestataire'];
        $ville = $prestataire['categorie_ville'];
      }
    }
  }
  $cout *= 1.3;

  if(isset($date_fin) && !empty($date_fin)){
    $nbJoursTime = strtotime($date_fin) - strtotime($date_debut);
    $nbJours = $nbJoursTime/86400 + 1;
    $cout *= $nbJours;
  }

  if(isset($_SESSION['mail'])){
    $req2 = $cx->prepare('SELECT * FROM user WHERE mail = ?');
    $req2->execute(array($_SESSION['mail']));
    $user = $req2->fetch();
    $req3 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $req3->execute(array($_POST['id']));
    $prestation = $req3->fetch();

    if($_POST['type'] != 2){
      $date_fin = $date_debut;
    }

    $session = \Stripe\Checkout\Session::create([
      'customer'=> $user['stripe_id'],
      'payment_method_types' => ['card'],
      'line_items' => [[
        'name' => $prestation['nom'],
        'description' => $prestation['description'],
        'amount' => $cout*100,
        'currency' => 'eur',
        'quantity' => 1,
      ]],
      'success_url' => URL."/finalpresta.php?session_id={CHECKOUT_SESSION_ID}&date_debut=".$date_debut."&date_fin=".$date_fin."&supplement=".$supplement."&user=".$user['id_user']."&user_ville=".$user['ville_reference']."&prestation=".$prestation['id_prestation']."&prestation_ville=".$prestation['categorie_ville']."&cout=".$cout,
      'cancel_url' => URL."/verifcostpresta.php?session_id=cancel",
    ]);
    echo "<div>
            <h3>Cette prestation vous couterai ".$cout."€, si vous voulez la réserver cliquez sur le bouton en dessous !</h3>
            <button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>
          </div>
          ";
  }
  else{
    echo "connectez vous et vous pourrez réserver !";
  }


?>
