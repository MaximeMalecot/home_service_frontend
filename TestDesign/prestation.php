

  <div class="btn-group">
    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Catégories </button>
    <ul class="dropdown-menu">


<?php
  include('config.php');
  $req = $cx->prepare('SELECT * FROM categorie');
  $req->execute();
  $categories = $req->fetchAll();

  foreach ($categories as $categorie ) {
    echo "<li><a href=\"#\"onclick=\"prestationcontent('".$categorie['nom']."')\" title=\"Lien ".$categorie['nom']."\">".$categorie['nom']."</a></li>";
  }

?>
    </ul>
    </div>
  <div class="container" id="prestationcontent">

  </div>
