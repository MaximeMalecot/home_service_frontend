<?php
  require_once "config.php";

  if(isset($_GET['id'])){
    $req = $cx->prepare('UPDATE demande SET etat = 1 WHERE id_demande = ?');
    $req->execute(array($_GET['id']));

    $req1 = $cx->prepare('SELECT * FROM demande WHERE etat = ?');
    $req1->execute(array(0));
    $demandes = $req1->fetchAll();
    $req2 = $cx->prepare('SELECT * FROM user WHERE id_user = ?');

    echo "<h1>Toutes les demandes : </h1>";
    foreach($demandes as $d){
      $req2->execute(array($d['user_id_user']));
      $duser = $req2->fetch();
      echo "<div class=\"askus\">".
              "Demande de : ".$duser['nom']." ".$duser['prenom']."<br/>".
              "Contact : <br/>".
                "Email : ".$duser['mail']."<br/>".
                "Phone : ".$duser['phone']."<br/>".
              "Description : ".$d['description']."<br/>".
              "<button class=\"btn btn-primary\" onclick=\"AskFinish('".$d['id_demande']."')\" >Demande vérifier et éxecutée</button>".
            "</div>";
    }
  }


?>
