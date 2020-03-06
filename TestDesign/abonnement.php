<div class="container" id="abonnements">
  <h1 id="title">Les abonnements :</h1>
<?php
  require_once "config.php";
  session_start();
  $req = $cx->prepare('SELECT * FROM abonnement ORDER BY id_abonnement ASC ');
  $req->execute();
  $abonnements = $req->fetchAll();
  if(isset($_SESSION['mail'])){
    $req1 = $cx->prepare('SELECT * FROM user WHERE mail = ?');
    $req1->execute(array($_SESSION['mail']));
    $user = $req1->fetch();

    if($user != NULL){

      $req2 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
      $req2->execute(array($user['id_user']));
      $current_souscription = $req2->fetch();
      $req3= $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
      $req3->execute(array($current_souscription['abonnement_id_abonnement']));
      $current_abonnement = $req3->fetch();


    }
  }

  foreach($abonnements as $abo){
    echo "<a href=\"abonnement_information.php?id=".$abo['id_abonnement']."\"><div id=".$abo['id_abonnement']." class=\"abos\" >
            <h2>".$abo['nom']." :</h2>
            <h3>Bénéficiez d'un accès privilégié en illimité ".$abo['temps']."j/7 de ".$abo['heure_debut']."h à ".$abo['heure_fin']."h !</h3>
            <h3>".$abo['nb_heure']."h de services/mois</h3>
            <h5 id=\"cout\">Coût : ".$abo['cout']."€ TTC / an</h5>
          </div></a>";
  }
?>
</div>
