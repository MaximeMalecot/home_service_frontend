<header>
  <?php
    session_start();
     $connected = isset($_SESSION["mail"]) ? true : false;
    ?>
  <section>
    <section id="head_title">
      <h1 id="title">Welcome to our website !</h1>
      <a href="index.php"><img src="img/logo.png" id="logo"></a>
    </section>
    <?php
    echo "<section id=\"connect\" class=\"inscription_connexion\">";
      if ($connected == false){
        include('connect_zone.php');
      }else{
        include('moncompte.php');
      }
      echo "</section>";
    ?>
  </section>
</header>
