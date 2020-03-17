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
  echo "
  <form id=\"form_connect\" method=\"POST\">
    <input type=\"mail\" placeholder=\"".$xml->header->formconnect->mail."\" id=\"mail\" class=\"form-control\" name=\"mail\"/>
    <input type=\"password\" placeholder=\"".$xml->header->formconnect->password."\" id=\"mdp\" class=\"form-control\" name=\"mdp\"/>
    <input class=\"btn btn-primary\" id = 'formconnexion'  onclick=\"verifconnect()\"value=\"".$xml->header->formconnect->connect."\" />
    <button class=\"btn btn-primary\" onclick=\"cancelco()\" id='cancelco'>".$xml->header->formconnect->cancel."</button>
  </form>";


?>
