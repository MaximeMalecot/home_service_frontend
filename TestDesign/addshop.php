<?php
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);

  if(isset($_GET['object']) && isset($_SESSION['mail'])){
    $json = json_decode($_GET['object'], true);
    $NewReservation = new Reservation($json['date_debut'],$json['date_fin'],$json['nb_unit'],$json['id_supplement'],$json['nb_supplement'],$_SESSION['mail'],$json['prestation_id_prestation'],$json['prestataire_id']);
    $NewReservation->setCout($json['cout']);

    $equal = 0;
    $i = 0;
    foreach ($_SESSION['reservations'] as $res){
      $rez = unserialize($res);
      if( (strcmp($rez->getDateDebut(), $NewReservation->getDateDebut() )==0) && (strcmp($rez->getDateFin(), $NewReservation->getDateFin())==0) && $rez->getUserIdUser() == $NewReservation->getUserIdUser() && $rez->getPrestationIdPrestation() == $NewReservation->getPrestationIdPrestation() ){
        if($rez->getNbUnit() != $NewReservation->getNbUnit() || $rez->getNbSupplement() != $NewReservation->getNbSupplement()){
          $equal +=1;
          $_SESSION['reservations'][$i] = serialize($NewReservation);
        }
        else{
          $equal +=1;
        }
      }
      $i+=1;
    }
    if($equal == 0){
      array_push($_SESSION['reservations'], serialize($NewReservation));
        echo "<br/>Votre prestation a bien été ajoutés au panier ! Vous avez actuellement ".count($_SESSION['reservations'])." prestations dans votre panier<br/>";
    }
    else{
      echo "Vous aviez dejà une prestation similaire avec des paramètres différents, elle a été modifiée !";
    }
  }

?>
