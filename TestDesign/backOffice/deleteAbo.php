<?php
  require_once "../config.php";
  require_once "../requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  if(isset($_POST['id'])){
    $req = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
    $req->execute(array($_POST['id']));
    $abo = $req->fetch();

    $req2 = $cx->prepare('SELECT * FROM souscription WHERE abonnement_id_abonnement = ?');
    $req2->execute(array($_POST['id']));
    $AllSouscriptions = $req2->fetchAll();
    if(!empty($AllSouscriptions)){
      echo "<h1>Impossible il y a des utilisateurs !</h1>";
      $reqAbo = $cx->prepare('SELECT * FROM abonnement ORDER BY cout ASC');
      $reqAbo->execute();
      $abos = $reqAbo->fetchAll();

      echo "<h1>Tous les abonnements : </h1>";
      echo "<form id=\"formabo\" method=\"POST\" action =\"changeAbo.php\">".
              "<table>
                <thead>
                  <tr>
                    <th>
                      <label>Nom</label>
                    </th>
                    <th>
                      <label>Cout</label>
                    </th>
                    <th>
                      <label>Nb_heure</label>
                    </th>
                    <th>
                      <label>Jours</label>
                    </th>
                    <th>
                      <label>Heure_début</label>
                    </th>
                    <th>
                      <label>Heure_fin</label>
                    </th>
                  </tr>
                </thead>
                <tbody>";
      foreach($abos as $abo){
        echo "<tr id=\"Abo".$abo['id_abonnement']."\">
                  <td id=\"nom".$abo['id_abonnement']."\">".$abo['nom']."</td>
                  <td id=\"cout".$abo['id_abonnement']."\">".$abo['cout']."</td>
                  <td id=\"nb_heure".$abo['id_abonnement']."\">".$abo['nb_heure']."</td>
                  <td id=\"temps".$abo['id_abonnement']."\">".$abo['temps']."</td>
                  <td id=\"heure_debut".$abo['id_abonnement']."\">".$abo['heure_debut']."</td>
                  <td id=\"heure_fin".$abo['heure_fin']."\">".$abo['heure_fin']."</td>
                  <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"displayInput('AboF".$abo['id_abonnement']."')\">modifier</button></td>
                  <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"deleteAbo('".$abo['id_abonnement']."')\">supprimer</button></td>
                </tr>";
        echo "<tr style=\"display:none;\" id=\"AboF".$abo['id_abonnement']."\">
                <td><input type=\"text\" id=\"inputNom".$abo['id_abonnement']."\" value=\"".$abo['nom']."\"></input></td>
                <td><input type=\"number\" id=\"inputCout".$abo['id_abonnement']."\" value=\"".$abo['cout']."\"></input></td>
                <td><input type=\"number\" id=\"inputNb".$abo['id_abonnement']."\" value=\"".$abo['nb_heure']."\"></input></td>
                <td><input type=\"number\" id=\"inputTemps".$abo['id_abonnement']."\" value=\"".$abo['temps']."\"></input></td>
                <td><input type=\"number\" id=\"inputHD".$abo['id_abonnement']."\" value=\"".$abo['heure_debut']."\"></input></td>
                <td><input type=\"number\" id=\"inputHF".$abo['id_abonnement']."\" value=\"".$abo['heure_fin']."\"></input></td>
                <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"modifyAbo('".$abo['id_abonnement']."')\">Confirmer</button></td>
                <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"hideInput('AboF".$abo['id_abonnement']."')\">Annuler</button></td>
              </tr>";
      }
      echo "<br/><tr>
                <td>
                  <input type=\"text\" id=\"nom\" placeholder=\"Nom de l'abonnement\"  />
                </td>
                <td>
                  <input type=\"text\" id=\"cout\" placeholder=\"Cout de l'abonnement\"  />
                </td>
                <td>
                  <input type=\"text\" id=\"nb_heure\" placeholder=\"Nombre d'heure d'abonnement\"  />
                </td>
                <td>
                  <input type=\"text\" id=\"temps\" placeholder=\"Jours accessibles\"  />
                </td>
                <td>
                  <input type=\"text\" id=\"heure_debut\" placeholder=\"Heure de début\"  />
                </td>
                <td>
                  <input type=\"text\" id=\"heure_fin\" placeholder=\"Heure de fin\"  />
                </td>
              </tr>
              <tbody>
            </table>
          </form>";
      die();
    }

    try{
      $prod = Stripe\Product::retrieve($abo['stripe_id']);
      $allPLan = \Stripe\Plan::all();
      foreach ($allPLan as $plan) {
        if($plan->product == $abo['stripe_id']){
          $plan->delete();
        }
      }
      $prod->delete();
    }
    catch(Exception $e){
      echo "Cet abonnement n'avait pas de liens vers stripe";
    }

    $req1 = $cx->prepare('DELETE FROM abonnement WHERE id_abonnement = ?');
    $req1->execute(array($_POST['id']));

    $reqAbo = $cx->prepare('SELECT * FROM abonnement ORDER BY cout ASC');
    $reqAbo->execute();
    $abos = $reqAbo->fetchAll();

    echo "<h1>Tous les abonnements : </h1>";
    echo "<form id=\"formabo\" method=\"POST\" action =\"changeAbo.php\">".
            "<table>
              <thead>
                <tr>
                  <th>
                    <label>Nom</label>
                  </th>
                  <th>
                    <label>Cout</label>
                  </th>
                  <th>
                    <label>Nb_heure</label>
                  </th>
                  <th>
                    <label>Jours</label>
                  </th>
                  <th>
                    <label>Heure_début</label>
                  </th>
                  <th>
                    <label>Heure_fin</label>
                  </th>
                </tr>
              </thead>
              <tbody>";
    foreach($abos as $abo){
      echo "<tr id=\"Abo".$abo['id_abonnement']."\">
                <td id=\"nom".$abo['id_abonnement']."\">".$abo['nom']."</td>
                <td id=\"cout".$abo['id_abonnement']."\">".$abo['cout']."</td>
                <td id=\"nb_heure".$abo['id_abonnement']."\">".$abo['nb_heure']."</td>
                <td id=\"temps".$abo['id_abonnement']."\">".$abo['temps']."</td>
                <td id=\"heure_debut".$abo['id_abonnement']."\">".$abo['heure_debut']."</td>
                <td id=\"heure_fin".$abo['heure_fin']."\">".$abo['heure_fin']."</td>
                <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"displayInput('AboF".$abo['id_abonnement']."')\">modifier</button></td>
                <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"deleteAbo('".$abo['id_abonnement']."')\">supprimer</button></td>
              </tr>";
      echo "<tr style=\"display:none;\" id=\"AboF".$abo['id_abonnement']."\">
              <td><input type=\"text\" id=\"inputNom".$abo['id_abonnement']."\" value=\"".$abo['nom']."\"></input></td>
              <td><input type=\"number\" id=\"inputCout".$abo['id_abonnement']."\" value=\"".$abo['cout']."\"></input></td>
              <td><input type=\"number\" id=\"inputNb".$abo['id_abonnement']."\" value=\"".$abo['nb_heure']."\"></input></td>
              <td><input type=\"number\" id=\"inputTemps".$abo['id_abonnement']."\" value=\"".$abo['temps']."\"></input></td>
              <td><input type=\"number\" id=\"inputHD".$abo['id_abonnement']."\" value=\"".$abo['heure_debut']."\"></input></td>
              <td><input type=\"number\" id=\"inputHF".$abo['id_abonnement']."\" value=\"".$abo['heure_fin']."\"></input></td>
              <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"modifyAbo('".$abo['id_abonnement']."')\">Confirmer</button></td>
              <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"hideInput('AboF".$abo['id_abonnement']."')\">Annuler</button></td>
            </tr>";
    }
    echo "<br/><tr>
              <td>
                <input type=\"text\" id=\"nom\" placeholder=\"Nom de l'abonnement\"  />
              </td>
              <td>
                <input type=\"text\" id=\"cout\" placeholder=\"Cout de l'abonnement\"  />
              </td>
              <td>
                <input type=\"text\" id=\"nb_heure\" placeholder=\"Nombre d'heure d'abonnement\"  />
              </td>
              <td>
                <input type=\"text\" id=\"temps\" placeholder=\"Jours accessibles\"  />
              </td>
              <td>
                <input type=\"text\" id=\"heure_debut\" placeholder=\"Heure de début\"  />
              </td>
              <td>
                <input type=\"text\" id=\"heure_fin\" placeholder=\"Heure de fin\"  />
              </td>
            </tr>
            <tbody>
          </table>
        </form>";
  }


 ?>
