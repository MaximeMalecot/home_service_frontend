<?php
  include('config.php');
  session_start();
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

   if(isset($_SESSION['mail'])){
     $req1 = $cx->prepare('SELECT * FROM souscription WHERE client_id_client = (SELECT id_client FROM client WHERE mail = ?)');
     $req1->execute(array($_SESSION['mail']));
     $souscription = $req1->fetch();
     $req2 = $cx->prepare('SELECT temps FROM abonnement WHERE id_abonnement = ?');
     $req2->execute(array($souscription['abonnement_id_abonnement']));
     $temps = $req2->fetch();
     if($souscription != false && $temps[0] >= $jour){
       echo "Créez votre propre prestation !";
     }
   }
   if ($prestations == false){
     echo "<div id=\"Unfortunate\">
            Malheureusement aucune prestation n'est disponible en ce moment...<br />
            Si vous voulez pouvoir créer une prestation en fonction de vos besoins, abonnez vous et nous répondrons dans les plus brefs délais !
            </div>";
    }

   foreach ($prestations as $prestation) {
     echo "<div class=\"container\">
            <h1>".$prestation[1]."</h1>".
            "<div>".$prestation[2]."</div>".
            "</div>";
   }

?>
