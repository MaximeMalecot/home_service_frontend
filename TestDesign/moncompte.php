<section class="inscription_connexion">

  <?php
    include('config.php');
    $req = $cx->prepare('SELECT pdp,pseudo from compte where email = ? ');
    $req->execute(array($_SESSION['email']));
    $user = $req->fetch();
    echo "<button onclick=\"settings()\">" . $user['pseudo'] . "</button>";
  ?>
  <a href="deconnexion.php">Se déconnecter</a>
</section>
