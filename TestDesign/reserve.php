<?php
  require_once "config.php";
  session_start();
  echo "ici pour réserver<br/>";
  $req = $cx->prepare('SELECT * FROM prestataire WHERE categorie_nom = ?');
  $req->execute(array($_POST['nom']));
  $prestataires = $req->fetchAll();

  print_r($prestataires);

  if($prestataires == false){
    echo "Aucun de nos prestataires n'est disponibles, vous pouvez toujours effectuer une demande si besoin <br/>";
  }
  else{
    echo "oui";
  }

  $test = "test";

  if($test == "test"){
    echo "ouiouioui";
  }



?>
