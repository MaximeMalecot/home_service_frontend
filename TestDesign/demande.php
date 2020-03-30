<?php
require_once "config.php";
ini_set('display_errors', '1');

  if(isset($_POST['user']) && isset($_POST['ville']) && isset($_POST['descript'])){
    $req= $cx->prepare('INSERT INTO demande(description,date,etat,user_id_user, user_ville_reference) VALUES (?,NOW(),?,?,?)');
    $req->execute(array($_POST['descript'],0,$_POST['user'],$_POST['ville']));
    echo "Votre demande a bien été enregistrée !";
  }


?>
