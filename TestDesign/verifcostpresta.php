<?php
  require_once "Class/Reservation.php";
  require_once "config.php";

  require_once "requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  if(isset($_POST['unit']) && !empty($_POST['unit'])){
    $unit = $_POST['unit'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if(isset($_POST['dd']) && !empty($_POST['dd'])){
    $date_debut = $_POST['dd'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if($_POST['type'] == 2){
    if(isset($_POST['df']) && !empty($_POST['df'])){
      $date_fin = $_POST['df'];
    }
    else{
      echo "Tous les champs n'était pas remplis";
      die();
    }
  }

  if(isset($_POST['sup']) && !empty($_POST['sup'])){
    $nb_supplement = $_POST['sup'];
  }
  else{
    $nb_supplement = 0;
  }

  if($_POST['type'] != 2){
    $date_fin = $date_debut;
  }

  if(isset($_POST['bareme']) && !empty($_POST['bareme'])){
    $req = $cx->prepare('SELECT * FROM bareme WHERE id_bareme = ?');
    $req->execute(array($_POST['bareme']));
    $bareme = $req->fetch();
    $req1 = $cx->prepare('SELECT * FROM supplement WHERE bareme_id_bareme = ?');
    $req1->execute(array($bareme['id_bareme']));
    $supplement = $req1->fetch();
    if($bareme == NULL){
      echo "Une erreur est survenue !";
    }
  }
  else{
    echo "Une erreur est survenue !";
  }


  if(isset($_SESSION['mail'])){
    $req2 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $req2->execute(array($_POST['id']));
    $prestation = $req2->fetch();

    $reserv = new Reservation($date_debut,$date_fin,$unit,$supplement['id_supplement'],$nb_supplement,$_SESSION['mail'],$prestation['id_prestation'], $bareme['prestataire_id_prestataire']);
    $reserv->setManCout($bareme['id_bareme']);

    echo "<div>
            <h2>Votre prestation vous couterais : ".$reserv->getCout()." €</h2>
            <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"addshop('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Ajouter au panier</button>
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
