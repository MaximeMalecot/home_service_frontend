<header>
  <?php
    require_once "Class/Reservation.php";
     $connected = isset($_SESSION["mail"]) ? true : false;
    ?>
  <section>
    <section id="head_title">
      <?php
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
      <h1 id="title"><?php echo $xml->header->title; ?></h1>
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
  <form method="post" action="redirect.php">
    <select id="langue" class="form-control"  name="langue" >
      <?php
      if(isset($choice)){
        if ($choice == "fr"){
          echo"
          <option value=\"fr\" onclick=\"this.form.submit()\" selected=\"selected\">FR</option>
          <option value=\"en\" onclick=\"this.form.submit()\">EN</option>
          ";
        }
        else if($choice == "en"){
          echo"
          <option value=\"fr\" onclick=\"this.form.submit()\">FR</option>
          <option value=\"en\" onclick=\"this.form.submit()\" selected=\"selected\">EN</option>
          ";
        }
        else{
            echo"
            <option value=\"fr\" onclick=\"this.form.submit()\">FR</option>
            <option value=\"en\" onclick=\"this.form.submit()\">EN</option>
            ";
        }
      }
      else{
          echo"
          <option value=\"fr\" onclick=\"this.form.submit()\">FR</option>
          <option value=\"en\" onclick=\"this.form.submit()\">EN</option>
          ";
      }


      ?>
    </select>
  </form>
    <div id="panier">
      <a href="panier.php"><img id="headpan" src="img/panier.png"></a>
    </div>
  </section>
</header>
