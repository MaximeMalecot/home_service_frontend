<?php
  require_once __DIR__ . "/bdd/database.env.php";
  require_once "Class/Reservation.php";

  $options = [
    'host=' . DB_HOST,
    'dbname=' . DB_NAME,
    'port=' . DB_PORT
  ];
  try{
    $cx = new PDO( DB_DRIVER . ':' . join( ';', $options),
                          DB_USER,
                          DB_PASSWORD);
  }
  catch(Exception $e){
    die('Erreur : '.$e->getMessage());
  }
  if(!isset($_SESSION)){
    session_start();
  }
  if(!isset($_SESSION['langue']) && empty($_SESSION['langue'])){
    $_SESSION['langue'] = "fr";
  }
?>
