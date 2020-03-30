<?php
  require_once "config.php";
  require_once "Class/Reservation.php";
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
      echo $tomorrow;
      echo "
            <table>
             <tr>
              <td align=\"center\">
                <label>Type de service : </label>
              </td>
              <td>
                <select id=\"type\" class=\"form-control\" onclick=\"select_type()\" name=\"type\">
                  <option value=\"1\">Basique</option>
                  <option value=\"2\">Récurrent</option>
                </select>
              </td>
             </tr>
             <br/>
             <tr>
              <td align=\"center\">
                <label>Nombre d'heures voulues (en cas de service récurrent, par jour) : </label>
              </td>
              <td>
                <input type=\"number\" id=\"heure\" class=\"form-control\" name=\"heure\"/>
              </td>
             </tr>
             <br/>
             <tr>
               <td align=\"center\">
                 <label>Date : </label>
               </td>
               <td>
                <input type=\"date\" id=\"date_debut\" class=\"form-control\" name=\"date_debut\" min=\"".$date."\"  onchange=\"deterdate()\"/>
               </td>
             </tr>
             <br/>
             <tr style=\"visibility: hidden\" id=\"input_date_fin\">
              <td align=\"center\">
                <label>Date de fin : </label>
              </td>
              <td>
                <input type=\"date\" id=\"date_fin\" class=\"form-control\" name=\"date_fin\" min=\"".$tomorrow."\" />
              </td>
             </tr>
             <br/>
             <br /><br />
             <tr>
              <td align=\"center\">
                <label>En cas de supplément ou de spécificités cochez cette case et faites nous les savoir</label>
              </td>
              <td>
                <input type=\"checkbox\" id=\"supplement\" name=\"supplement\" onchange=\"addsuppl()\"/>
              </td>
             </tr>
             <tr style=\"visibility: hidden\" id=\"input_spec\">
              <td align=\"center\">
                <label>Renseigner vos spécificités </label>
              </td>
              <td>
                <input type=\"text\" id=\"spec\" class=\"form-control\"name=\"spec\" />
              </td>
             </tr>
             <tr>
               <td align=\"center\">
                <button class=\"btn btn-primary\" onclick=\"getcost('".$_POST['id']."','".$_POST['nom']."')\" id='getcost'>Connaitre le cout de la prestation</button>
               </td>
             </tr>
             </table>
            </div>
            <br/>";
  }
  }

?>
<div id="finalpresta">

</div>
