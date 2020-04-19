<?php
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);

  if(isset($_GET['object']) && isset($_SESSION['mail']) && isset($_GET['id'])){
    $json = json_decode($_GET['object'], true);
    $NewReservation = new Reservation(new DateTime($json['date_debut']['date']),new DateTime($json['date_fin']['date']),$json['nb_unit'],$json['id_supplement'],$json['nb_supplement'],$_SESSION['mail'],$json['prestation_id_prestation'],$json['prestataire_id']);
    $NewReservation->setCout($json['cout']);
    $_SESSION['reservations'][$_GET['id']] = serialize($NewReservation);

    echo "<h1>Votre réservation a bien été modifié !</h1>";
  }



?>
