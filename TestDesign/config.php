<?php
  require_once __DIR__ . "/bdd/database.env.php";
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
?>
