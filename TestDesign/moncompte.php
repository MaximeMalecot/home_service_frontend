<section id ="secondconnect" class="inscription_connexion">
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

    $req = $cx->prepare('SELECT prenom from user where mail = ? ');
    $req->execute(array($_SESSION['mail']));
    $user = $req->fetch();
    echo "<h3 id=\"goaccount\"><a href='settings.php'>".$xml->header->myaccount->hello.$user['prenom']. "</a></h3>";
  ?>
  <p id="deconnect"><a href="deconnexion.php"><?php echo $xml->header->myaccount->deco; ?></a></p>
</section>
