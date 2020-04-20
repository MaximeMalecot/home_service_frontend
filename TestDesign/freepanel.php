<?php
  require_once "config.php";
  require_once "Class/Reservation.php";
  require_once "Stripe/init.php";
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

    $rez= unserialize($_SESSION['reservations'][$_GET['index']])
    $reqReservation=$cx->prepare('INSERT INTO reservation(date_debut,date_fin,nb_unite,id_supplement,nb_unit_suplement,user_id_user,user_ville_reference,prestation_id_prestation,prestation_ville) VALUES(?,?,?,?,?,?,?,?,?)');
    $reqFacturation=$cx->prepare('INSERT INTO facturation(date,cout,id_user,reservation_id_reservation,prestataire_id_prestataire,prestataire_ville) VALUES(NOW(),?,?,?,?,?)');
    $reqReservation->execute(array(
      $rez->getDateDebut(),
      $rez->getDateFin(),
      $rez->getNbUnit(),
      $rez->getIdSupplement(),
      $rez->getNbSupplement(),
      $rez->getUserIdUser(),
      $rez->getUserVilleReference(),
      $rez->getPrestationIdPrestation(),
      $rez->getPrestationVille()
    ));
    $lastId = $cx->lastInsertId();
    $reqFacturation->execute(array(
      0,
      $rez->getUserIdUser(),
      $lastId,
      $rez->getPrestataireId(),
      $rez->getPrestataireVille()
    ));

    $req2=$cx->prepare('UPDATE souscription SET heure_restante = ? WHERE user_id_user = ?');
    $req2->execute(array($heure,$user['id_user']));

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
        echo "Il vous reste ".$sous['heure_restante']." unités gratuite grâce à votre abonnement !<br />";
        $req2= $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
        $req3= $cx->prepare('SELECT * FROM bareme WHERE prestation_id_prestation = ?');
        $i = 0;
        foreach ($_SESSION['reservations'] as $res) {

          $rez = unserialize($res);
          $cout += $rez->getCout();
          $req2->execute(array($rez->getPrestationIdPrestation()));
          $pres = $req2->fetch();
          $req3->execute(array($rez->getPrestationIdPrestation()));
          $bareme = $req3->fetch();
          echo "<div class=\"prestapannel\">
                  <h2>Prestation : ".$pres['nom']."</h1>
                  <h4>".$rez->getNbUnit()." ".$bareme['unite']." pour un prix de : ".$rez->getCout()." €</h2>
                  <h4>Supplement : ".$rez->getNbSupplement()."</h4>";
                  if(strcmp($rez->getDateDebut(),$rez->getDateFin()) != 0){
                    echo "<h4>Commence le : ".$rez->getDateDebut()." et finit le : ".$rez->getDateFin()." avec ".$rez->getNbUnit()." ".$bareme['unite']." par jour</h4>";
                    $nbJoursTime = strtotime($rez->getDateFin()) - strtotime($rez->getDateDebut());
                    $nbJours = ($nbJoursTime/86400) + 1;
                    $totH = $nbJours * $rez->getNbUnit();
                  }
                  else{
                    echo "<h4>A lieu le : ".$rez->getDateDebut()." pendant ".$rez->getNbUnit()." ".$bareme['unite']."</h4>";
                    $totH = $rez->getNbUnit();
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
  else{
    echo "Votre panier est vide !";
  }
?>
