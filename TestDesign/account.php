<?php
  include('config.php');
  session_start();
  $connected = isset($_SESSION["mail"]) ? true : false;
  if (!$connected){
    header('Location: Index.php');
  }

?>
