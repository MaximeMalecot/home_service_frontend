<div class="container" id="abonnements">
  <h1>Les abonnements :</h1>
<?php
  require_once "config.php";
  $req = $cx->prepare('SELECT * FROM abonnement ORDER BY id_abonnement ASC ');
  $req->execute();
  $abonnements = $req->fetchAll();

  foreach($abonnements as $abo){
    echo "<a href=\"abonnement_information.php?id=".$abo['id_abonnement']."\"><div id=".$abo['id_abonnement']." class=\"abos\" >
            <h2>".$abo['nom']." :</h2>
            <h3>Bénéficiez d'un accès privilégié en illimité ".$abo['temps']."j/7 de ".$abo['heure_debut']."h à ".$abo['heure_fin']."h !</h3>
            <h3>".$abo['nb_heure']."h de services/mois</h3>
            <h5>Coût : ".$abo['cout']."€ TTC / an</h5>
          </div></a>";
  }
?>
</div>
