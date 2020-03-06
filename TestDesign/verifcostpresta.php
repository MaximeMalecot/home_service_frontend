<?php
  require_once "config.php";
  session_start();
  $req = $cx->prepare('SELECT * FROM prestataire WHERE categorie_nom = ?');
  $req->execute(array($_POST['nom']));
  $prestataires = $req->fetchAll();
  ini_set('display_errors', '1');

  if(isset($_POST['heure']) && !empty($_POST['heure'])){
    $heure = $_POST['heure'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if(isset($_POST['date_debut']) && !empty($_POST['date_debut'])){
    $date_debut = $_POST['date_debut'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if($_POST['type'] == 2){
    if(isset($_POST['date_fin']) && !empty($_POST['date_fin'])){
      $date_fin = $_POST['date_fin'];
    }
    else{
      echo "Tous les champs n'était pas remplis";
      die();
    }
  }

  $supplement = $_POST['supplement'];


  $cout = 0;
  $id = 0;
  $ville;
  foreach($prestataires as $prestataire){
    if($supplement == 1){
      if( ($prestataire['prix_heure'] + $prestataire['supplement']) > $cout){
        $cout = ($prestataire['prix_heure'] + $prestataire['supplement']);
        $id = $prestataire['id_prestataire'];
        $ville = $prestataire['categorie_ville'];
      }
    }
    else{
      if($prestataire['prix_heure'] > $cout){
        $cout = $prestataire['prix_heure'];
        $id = $prestataire['id_prestataire'];
        $ville = $prestataire['categorie_ville'];
      }
    }
  }
  if(isset($date_fin) && !empty($date_fin)){
    $nbJoursTime = strtotime($date_fin) - strtotime($date_debut);
    $nbJours = $nbJoursTime/86400 + 1;
    $cout *= $nbJours;
  }

  if(isset($_SESSION['mail'])){
    echo "<div>
            Cette prestation vous couterai ".$cout."€, si vous voulez la réserver cliquez sur le bouton en dessous !
            <input class=\"btn btn-primary\" onclick()=\"takepresta('".$_POST['id']."','".$id."','".$cout."','".$ville."')\" value=\"Réserver\" />
            <script type=\"text/javascript\" src=\"js/script.js\"></script>
          </div>
          ";
  }
  else{
    echo "connectez vous et vous pourrez réserver !";
  }


?>
