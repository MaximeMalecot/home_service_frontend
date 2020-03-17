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
  <div id="BtnCatTogle" class="btn-group" >
    <button id="BtnTitle" type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $xml->main->presta->titlebtn; ?></button>
    <ul class="dropdown-menu">


<?php
  require_once "config.php";
  $req = $cx->prepare('SELECT * FROM categorie');
  $req->execute();
  $categories = $req->fetchAll();

  foreach ($categories as $categorie ) {
    echo "<li><a href=\"#\"onclick=\"prestationcontent('".$categorie['nom']."')\" title=\"Lien ".$categorie['nom']."\">".$categorie['nom']."</a></li>";
  }

?>
    </ul>
    </div>
    <br />
  <div class="container" id="prestationcontent">

  </div>
