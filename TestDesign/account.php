<?php
  include('config.php');
  session_start();
  $connected = isset($_SESSION["email"]) ? true : false;
  if (!$connected){
    header('Location: Index.php');
  }

?>
