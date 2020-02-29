<?php

try{
  $cx = new PDO('mysql:host=localhost;dbname=mydb','developper','toz');
}
catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}
?>
