<?php
  include('config.php');
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

   foreach ($prestations as $prestation) {
     echo "<div class=\"container\">
            <h1>".$prestation[1]."</h1>".
            "<div>".$prestation[2]."</div>".
            "</div>";
   }

?>
