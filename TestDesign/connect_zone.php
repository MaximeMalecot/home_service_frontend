
<?php
  require_once "config.php";
  if(isset($_SESSION['langue'])){
    $choice = $_SESSION['langue'];
    $fichier = "xml/".$choice.".xml";
    $xml = simplexml_load_file($fichier);
  }
  else{
    $choice = "fr";
    $fichier = "xml/".$choice.".xml";
    $xml = simplexml_load_file($fichier);
  }
 ?>
  <button id="getco" onclick="connection()"><h4><?php echo $xml->header->getco; ?></h4></button>
  <p id="creation"><a href="register.php" ><?php echo $xml->header->creation;?></a></p>
