<header>
  <?php
    session_start();
     $connected = isset($_SESSION["email"]) ? true : false;
    ?>
  <section>
    <section id="head_title">
      <h1 id="title">Welcome to our website !</h1>
      <a href="newindex.php"><img src="img/logo.png" id="logo"></a>
    </section>
    <?php
      if ($connected == false){
        include('register.php');
      }else{
        include('mon_compte.php');
      }
    ?>
    <section id="info">
        SUPER
    </section>
  </section>
</header>
