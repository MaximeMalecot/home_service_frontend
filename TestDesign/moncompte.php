<section id ="secondconnect" class="inscription_connexion">
  <?php
    require_once "config.php";
    $req = $cx->prepare('SELECT prenom from user where mail = ? ');
    $req->execute(array($_SESSION['mail']));
    $user = $req->fetch();
    echo "<h3 id=\"goaccount\"><a href='settings.php'> Bonjour " . $user['prenom'] . "</a></h3>";
  ?>
  <p id="deconnect"><a href="deconnexion.php">Se déconnecter</a></p>
</section>
