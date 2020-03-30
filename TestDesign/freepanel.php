<?php
  require_once "config.php";
  require_once "Class/Reservation.php";
  require_once "requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
  ini_set('display_errors', '1');

  if(isset($_GET['index']) && isset($_GET['heure']) && isset($_SESSION['mail'])){
    $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
    $req->execute(array($_SESSION['mail']));
    $user = $req->fetch();
    $req1 = $cx->prepare('SELECT * FROM  souscription WHERE user_id_user = ?');
    $req1->execute(array($user['id_user']));
    $sous = $req1->fetch();
    $heure = $sous['heure_restante'] - $_GET['heure'];
    $req2=$cx->prepare('UPDATE souscription SET heure_restante = ? WHERE user_id_user = ?');
    $req2->execute(array($heure,$user['id_user']));

    $req3=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,nb_heure,supplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES (DATE(?),DATE(?),?,?,?,?,?,?)');
    $req4=$cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $req5=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation) VALUES(NOW(),?,?,?)');

    $rez= unserialize($_SESSION['reservations'][$_GET['index']]);
    $req4->execute(array($rez->getPID()));
    $PVR = $req4->fetch();
    $req3->execute(array(
      $rez->getDateDebut(),
      $rez->getDateFin(),
      $rez->getNbHeure(),
      $rez->getSupplement(),
      $rez->getUID(),
      $rez->getUVR(),
      $rez->getPID(),
      $PVR['categorie_ville']
    ));
    $lastId = $cx->lastInsertId();
    echo $lastId;
    $req5->execute(array(
      0,
      $rez->getUID(),
      $lastId
    ));


    unset($_SESSION['reservations'][$_GET['index']]);
    $_SESSION['reservations'] = array_values($_SESSION['reservations']);

    echo "Votre réservation gratuite à bien été prise en compte !<br />";



  }
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
        echo "Il vous reste ".$sous['heure_restante']." heure gratuite grâce à votre abonnement !<br />";
        $req2= $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
        $i = 0;
        echo "<div id=\"totalPrestaPannel\">";
        foreach ($_SESSION['reservations'] as $res) {

          $rez = unserialize($res);
          $cout += $rez->getCout();
          $req2->execute(array($rez->getPID()));
          $pres = $req2->fetch();
          echo "<div class=\"prestapannel\">
                  <h2>Prestation : ".$pres['nom']."</h1>
                  <h4>".$rez->getNbHeure()." heures pour un prix de : ".$rez->getCout()." €</h2>
                  <h4>Supplement : ".$rez->getSupplement()."</h4>";
                  if(strcmp($rez->getDateDebut(),$rez->getDateFin()) != 0){
                    echo "<h4>Commence le : ".$rez->getDateDebut()." et finit le : ".$rez->getDateFin()." avec ".$rez->getNbHeure()." heures par jour</h4>";
                    $nbJoursTime = strtotime($rez->getDateFin()) - strtotime($rez->getDateDebut());
                    $nbJours = ($nbJoursTime/86400) + 1;
                    $totH = $nbJours * $rez->getNbHeure();
                    echo " total de ".$totH."heures<br />";
                  }
                  else{
                    echo "<h4>A lieu le : ".$rez->getDateDebut()." pendant ".$rez->getNbHeure()." heures</h4>";
                    $totH = $rez->getNbHeure();
                    echo " total de ".$totH."heures<br />";
                  }
                  if($sous['heure_restante'] > $totH){
                    echo "<button class=\"btn btn-primary\" onclick=\"deleteHours('".$i."')\">L'avoir gratuitement</button>";
                  }



                echo "</div>";
                $i+=1;
        }
        echo "<br /><br />Total : ".$cout."<br /><br />";
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
            'cancel_url' => URL."/verifcostpresta.php?session_id=cancel",
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
          echo $rez->getNbHeure()."<br />";
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
            'cancel_url' => URL."/verifcostpresta.php?session_id=cancel",
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
?>
