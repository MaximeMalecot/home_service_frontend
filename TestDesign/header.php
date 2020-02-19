<header>
  <?php
    session_start();
     $connected = isset($_SESSION["email"]) ? true : false;
    ?>
  <section>
    <section id="head_title">
      <h1 id="title">Welcome to our website !</h1>
      <a href="index.php"><img src="img/logo.png" id="logo"></a>
    </section>
    <?php
      if ($connected == false){
        include('connect_zone.php');
      }else{
        include('moncompte.php');
      }

      if(isset($_GET['error'])){
      echo "<p id=\"Error\">Something was incorrect</p>";
      }
    ?>
    <section id="info">
    </section>
  </section>
</header>
