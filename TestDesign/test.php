<?php
  require_once "config.php";
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);

  if(isset($_GET['object'])){
    $test = json_decode($_GET['object'], true);
    $reserve = new Reservation( $test['nb_heure'],$test['date_debut'],$test['date_fin'],$test['supplement'],$_SESSION['mail'],$test['prestation_id_prestation']);
    $reserve->SimpleCout($test['cout']);

    array_push($_SESSION['reservations'], $reserve);
  }



?>
