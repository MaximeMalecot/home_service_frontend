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
<footer>
  <div id="footer_wrapper">
    <nav id="links_footer">
      <ul>
        <li id="sponsors"><a href="nos_sponsors"><?php echo $xml->footer->sponsors; ?></a></li>
        <li id="contact"><a href="contactez nous"><?php echo $xml->footer->contact; ?></a></li>
      </ul>
    </nav>
    <h2 id="Copyright"><?php echo $xml->footer->cpr; ?></h2>
  </div>
</footer>
