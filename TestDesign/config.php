<?php

try{
  $cx = new PDO('mysql:host=localhost;dbname=frontend','developper','toz');
}
catch(Exception $e){
  die('Erreur : '.$e->getMessage());
}
?>
