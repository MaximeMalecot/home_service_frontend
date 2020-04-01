<?php
  require_once "../config.php";
  require_once "../requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  if(isset($_POST['id'])){
    try{
      $req= $cx->prepare('DELETE FROM souscription WHERE stripe_id = ?');
      $req->execute(array($_POST['id']));

      $currentsub = \Stripe\Subscription::retrieve($_POST['id']);
      $currentsub->delete();
      //////////////////////AFFICHAGE///////////////////
      echo "<h1>Toutes les souscriptions : </h1>";

      $reqSous = $cx->prepare('SELECT * FROM souscription');
      $reqSous->execute();
      $souscriptions = $reqSous->fetchAll();

      echo "<form id=\"formsous\" method=\"POST\" action =\"changeSous.php\">".
            "<table>
              <thead>
                <tr>
                  <th>
                    <label>Abonnement</label>
                  </th>
                  <th>
                    <label>Date</label>
                  </th>
                  <th>
                    <label>Heure restantes</label>
                  </th>
                  <th>
                    <label>User id</label>
                  </th>
                  <th>
                    <label>User ville</label>
                  </th>
                  <th>
                    <label>Stripe id</label>
                  </th>
                </tr>
              </thead>
              <tbody>";
        foreach($souscriptions as $s){
          echo "<tr id=\"Sous".$s['stripe_id']."\">
                    <td id=\"abo".$s['stripe_id']."\">".$s['abonnement_id_abonnement']."</td>
                    <td id=\"date".$s['stripe_id']."\">".$s['date']."</td>
                    <td id=\"heure".$s['stripe_id']."\">".$s['heure_restante']."</td>
                    <td id=\"user".$s['stripe_id']."\">".$s['user_id_user']."</td>
                    <td id=\"ville".$s['stripe_id']."\">".$s['user_ville_reference']."</td>
                    <td id=\"stripe".$s['stripe_id']."\">".$s['stripe_id']."</td>
                    <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"deleteSous('".$s['stripe_id']."')\">supprimer</button></td>
                  </tr>";
        }
        echo "<br/><tr style=\"visibility: hidden;\">
                  <td>
                    <input type=\"text\" id=\"nom\" placeholder=\"ID abonnement\"  />
                  </td>
                  <td>
                    <input type=\"text\" id=\"cout\" placeholder=\"Date de souscription\"  />
                  </td>
                  <td>
                    <input type=\"text\" id=\"nb_heure\" placeholder=\"Heure restantes\"  />
                  </td>
                  <td>
                    <input type=\"text\" id=\"temps\" placeholder=\"User ID\"  />
                  </td>
                  <td>
                    <input type=\"text\" id=\"heure_debut\" placeholder=\"User Ville\"  />
                  </td>
                  <td>
                    <input type=\"text\" id=\"heure_fin\" placeholder=\"Stripe ID\"  />
                  </td>
                </tr>
                <tbody>
              </table>
            </form>";

    }
    catch(Exception $e){
      echo "une erreur est survenue";
    }

  }


?>
