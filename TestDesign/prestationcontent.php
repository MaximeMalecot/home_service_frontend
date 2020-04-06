<div id="prestations">
<?php
  require_once "config.php";
  require_once "Class/Reservation.php";
  if(isset($_GET['nom']) AND !empty($_GET['nom'])) {
      $nom = $_GET['nom'];
   }else{
       echo 'Une erreur est survenue, veuillez réessayer!';
   }

   $req = $cx->prepare('SELECT * FROM prestation WHERE categorie_nom = :nom');
   $req->execute(array(
     'nom'=>$nom
   ));
   $prestations = $req->fetchAll();

   $jour = date("w");
   $jour == 0 ? $jour = 7 : $jour = $jour;
   $h = date("H");

   if(isset($_SESSION['mail'])){

     $req1 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = (SELECT id_user FROM user WHERE mail = ?)');
     $req1->execute(array($_SESSION['mail']));
     $souscription = $req1->fetch();
     $req2 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
     $req2->execute(array($souscription['abonnement_id_abonnement']));
     $abo = $req2->fetch();
     if ($prestations == false){
       echo "<div id=\"Unfortunate\">
              <h2>Malheureusement aucune prestation n'est disponible en ce moment...<br />";
              if($souscription != false && $abo['temps'] >= $jour && $h > $abo['heure_debut'] && $h < $abo['heure_fin']){
                      echo "Vous pouvez tout de même faire la demande d'une prestation à HomeService, vous aurez une réponse sous peu !</h2>
                            <input class=\"btn btn-primary\" onclick=\"newPresta()\" value=\"Faire une demande\"/>".
                          "</div>";
                    }
              else{
                echo "Si vous voulez pouvoir créer une prestation en fonction de vos besoins, abonnez vous et nous répondrons dans les plus brefs délais !</h2></div>";
              }
      }
      else{
        if($souscription != false && $abo['temps'] >= $jour && $h > $abo['heure_debut'] && $h < $abo['heure_fin']){
          echo "<div id=\"Fortunate\">
                   <h2>Aucune prestation ne vous convient ? Faites la demande d'une prestation !</h2>
                   <input class=\"btn btn-primary\" onclick=\"newPresta()\" value=\"Faire une demande\"/>".
               "</div>";
        }
      }
  }

   foreach ($prestations as $prestation) {
     echo "<div class=\"presta\">
            <h1>".$prestation[1]." : </h1>".
            "<div>".$prestation[2]."</div>".
            "<input class=\"btn btn-primary\" onclick=\"reserve('".$prestation[0]."','".$nom."')\" value=\"Réserver la prestation\"/>".
          "</div>";
   }

?>
</div>
