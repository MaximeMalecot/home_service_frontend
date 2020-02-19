<section id ="secondconnect" class="inscription_connexion">
  <?php
    include('config.php');
    $req = $cx->prepare('SELECT Nom from User where email = ? ');
    $req->execute(array($_SESSION['email']));
    $user = $req->fetch();
    echo "<h3 id=\"goaccount\"><a href='settings.php'>" . $user['Nom'] . "</a></h3>";
  ?>
  <p id="deconnect"><a href="deconnexion.php">Se déconnecter</a></p>
</section>
