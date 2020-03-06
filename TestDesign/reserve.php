<?php
  require_once "config.php";
  session_start();
  ini_set('display_errors', '1');
  if(isset($_POST['nom']) && isset($_POST['id'])){
    $req = $cx->prepare('SELECT * FROM prestataire WHERE categorie_nom = ?');
    $req->execute(array($_POST['nom']));
    $prestataires = $req->fetchAll();
    if($prestataires == NULL){
      echo "Aucun de nos prestataires n'est disponibles, vous pouvez toujours effectuer une demande si besoin <br/>";
    }
    else{
      echo "<div id=\"getprestation\">
            <h4>Nous sommes heureux de vous voir ici, renseignez les informations ci-dessous pour réserver une prestation personnalisée!</h4>";
      $date = date("Y-m-d");
      $tomorrow = date('Y-m-d', strtotime($date . ' +1 day'));
      echo "
            <table>
             <tr>
              <td align=\"right\">
                <label>Type de service : </label>
              </td>
              <td>
                <select id=\"type\" class=\"form-control\" onclick=\"select_type()\" name=\"type\">
                  <option value=\"1\">Basique</option>
                  <option value=\"2\">Récurrent</option>
                </select>
              </td>
             </tr>
             <tr>
              <td align=\"right\">
                <label>Nombre d'heures voulues (en cas de service récurrent, par jour) : </label>
              </td>
              <td>
                <input type=\"number\" id=\"heure\" class=\"form-control\" name=\"heure\"/>
              </td>
             </tr>
             <tr>
               <td align=\"right\">
                 <label>Date : </label>
               </td>
               <td>
                <input type=\"date\" id=\"date_debut\" class=\"form-control\" name=\"date_debut\" min=\"".$date."\"  />
               </td>
             </tr>
             <tr style=\"visibility: hidden\" id=\"input_date_fin\">
              <td align=\"right\">
                <label>Date de fin : </label>
              </td>
              <td>
                <input type=\"date\" id=\"date_fin\" class=\"form-control\" name=\"date_fin\" min=\"".$tomorrow."\" />
              </td>
             </tr>
             <br /><br />
             <tr>
              <td align=\"right\">
                <label>En cas de supplément ou de spécificités cochez cette case et faites nous les savoir</label>
              </td>
              <td>
                <input type=\"checkbox\" id=\"supplement\" name=\"supplement\" onchange=\"addsuppl()\"/>
              </td>
             </tr>
             <tr style=\"visibility: hidden\" id=\"input_spec\">
              <td align=\"right\">
                <label>Renseigner vos spécificités </label>
              </td>
              <td>
                <input type=\"text\" id=\"spec\" class=\"form-control\"name=\"spec\" />
              </td>
             </tr>
             <tr>
               <td align=\"right\">
                <button class=\"btn btn-primary\" onclick=\"getcost('".$_POST['id']."','".$_POST['nom']."')\" id='getcost'>Connaitre le cout de la prestation</button>
               </td>
             </tr>

            </div>
            <div id=\"finalpresta\">

            </div>";
      /*
      $cout = 0;
      $id = 0;
      $ville;
      foreach($prestataires as $prestataire){
        if(($prestataire['prix_heure'] + $prestataire['supplement']) > $cout){
          $cout = ($prestataire['prix_heure'] + $prestataire['supplement']);
          $id = $prestataire['id_prestataire'];
          $ville = $prestataire['categorie_ville'];
        }
      }
      echo $id."<br />".$cout;
      if( $cout != NULL && $id != NULL && $ville!=NULL){
        echo "<div>
                <h1>Nous sommes heureux de vous voir ici !</h1>
                <h2>Nous avons pu vous trouver un prestaire, il vous sera facturé </h2>
              </div>";
      }
    }*/
  }
  }

?>
