<?php
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);

  if(isset($_GET['object'])){
    $test = json_decode($_GET['object'], true);
    $reserve = new Reservation( $test['nb_heure'],$test['date_debut'],$test['date_fin'],$test['supplement'],$_SESSION['mail'],$test['prestation_id_prestation']);
    $reserve->SimpleCout($test['cout']);
    $equal = 0;
    $i = 0;
    foreach ($_SESSION['reservations'] as $res) {
      $rez = unserialize($res);
      if((strcmp($rez->getDateDebut(),$reserve->getDateDebut())==0) && (strcmp($rez->getDateFin(),$reserve->getDateFin())==0) && $rez->getUID() == $reserve->getUID() && $rez->getPID() == $reserve->getPID()){
        if($rez->getNbHeure() != $reserve->getNbHeure() && $rez->getCout() != $reserve->getCout() && (strcmp($rez->getSupplement(),$reserve->getSupplement()) != 0)){
          $rez->setSupplement($reserve->getSupplement());
          $rez->setCout($reserve->getCout());
          $rez->setNbHeure($reserve->getNbHeure());
          $equal += 1;
          $_SESSION['reservations'][$i] = serialize($reserve);
        }
        else{
          $equal += 1;
        }
      }
      $i+=1;
    }
    if($equal == 0){
      array_push($_SESSION['reservations'], serialize($reserve));
      echo "<br/>Votre prestation a bien été ajoutés au panier ! Vous avez actuellement ".count($_SESSION['reservations'])." prestations dans votre panier<br/>";
    }
    else{
      echo "Vous aviez dejà une prestation similaire avec des paramètres différents, elle a été modifiée !";
    }
  }

?>
