<?php
  require_once "config.php";
  ini_set('display_errors', '1');

  if(isset($_SESSION['mail'])){
    $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
    $req->execute(array($_SESSION['mail']));
    $user = $req->fetch();
    echo "<div id=\"formask\">
            <table>
              <tr>
                <td align=\"right\">
                  <label>Description : </label>
                </td>
                <td>
                  <textarea id=\"descript\" maxlength=1000 oninput=\"verifytext()\"placeholder=\"Votre description (maximum 1000 charactères)\"></textarea>
                </td>
              </tr>
              <tr>
                <td align=\"center\">
                  <button id=\"btnCreate\" style=\"visibility: hidden;\" class=\"btn btn-primary\" onclick=\"createAsk('".$user['id_user']."','".$user['ville_reference']."')\">Créer</button>
                </td>
              </tr>
            </table>
          </div>";
  }
 ?>
 <div id="resultask">

 </div>
