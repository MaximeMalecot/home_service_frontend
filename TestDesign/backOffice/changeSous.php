<?php
  require_once "../config.php";
  require_once "../requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  if(isset($_POST['id']) && isset($_POST['abo']) && isset($_POST['date']) && isset($_POST['heure'])){
    $req = $cx->prepare('SELECT * FROM souscription WHERE stripe_id = ?');
    $req->execute(array($_POST['id']));
    $CurrentSous = $req->fetch();

    if($_POST['abo'] == $CurrentSous['abonnement_id_abonnement']){
      echo "same";
      if( !empty($_POST['date']) ){
        $date = $_POST['date'];
        echo $_POST['date'];
      }
      else{
        echo "pas de date";
      }
    }
    else{
      echo "notsame";
      echo $_POST['date'];
    }
  }


?>
