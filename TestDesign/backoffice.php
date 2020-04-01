<html>
<head>
	<title>Home Service</title>
	<link rel="stylesheet" type="text/css" href="Style/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="Style/style.css">
	<meta charset="utf-8">
</head>
<body>
  <?php
		include('header.php');
	?>
  <main>
    <?php
      require_once "config.php";
      if(isset($_SESSION['mail']) ){
        $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
        $req->execute(array($_SESSION['mail']));
        $user = $req->fetch();
        if(strcmp($user['statut'], "admin") == 0){
          echo "<div>
                  <ul>
                    <li><a href=\"#AllAskUs\">Demandes</a></li>
                    <li><a href=\"#Abos\">Abonnements</a></li>
										<li><a href=\"#Souscriptions\">Souscriptions</a></li>
                  </ul>
                </div>";


          /////////////////////////DEMANDES////////////////////////////
          $req1 = $cx->prepare('SELECT * FROM demande WHERE etat = ?');
          $req1->execute(array(0));
          $demandes = $req1->fetchAll();
          $req2 = $cx->prepare('SELECT * FROM user WHERE id_user = ?');
          echo "<section id=\"AllAskUs\" class=\"BackOfficeSection\">".
                  "<h1>Toutes les demandes : </h1>";
          foreach($demandes as $d){
            $req2->execute(array($d['user_id_user']));
            $duser = $req2->fetch();
            echo "<div class=\"askus\">".
                    "Demande de : ".$duser['nom']." ".$duser['prenom']."<br/>".
                    "Contact : <br/>".
                      "Email : ".$duser['mail']."<br/>".
                      "Phone : ".$duser['phone']."<br/>".
                    "Description : ".$d['description']."<br/>".
                    "<button class=\"btn btn-primary\" onclick=\"AskFinish('".$d['id_demande']."')\" >Demande vérifiée et éxecutée</button>".
                  "</div>";
          }
          echo "</section>";

          ////////////////////////ABONNEMENTS////////////////////////
          echo "<section id=\"Abos\" class=\"BackOfficeSection\">".
                  "<h1>Tous les abonnements : </h1>";
          $reqAbo = $cx->prepare('SELECT * FROM abonnement');
          $reqAbo->execute();
          $abos = $reqAbo->fetchAll();

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
                      <td><button type=\"button\" class=\"btn btn-sm\" onclick=\"\">supprimer</button></td>
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
          echo "</section>";
					///////////////////////SOUSCRIPTIONS/////////////////////////////
					echo "<section id=\"Souscriptions\" class=\"BackOfficeSection\">".
                  "<h1>Toutes les souscriptions : </h1>";
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
												<td><button type=\"button\" class=\"btn btn-sm\" onclick=\"displayInput('SousF".$s['stripe_id']."')\">modifier</button></td>
												<td><button type=\"button\" class=\"btn btn-sm\" onclick=\"\">supprimer</button></td>
											</tr>";
							echo "<tr style=\"display:none;\" id=\"SousF".$s['stripe_id']."\">
											<td><input type=\"text\" id=\"inputAbo".$s['stripe_id']."\" value=\"".$s['abonnement_id_abonnement']."\"></input></td>
											<td><input type=\"date\" id=\"inputDate".$s['stripe_id']."\" value=\"".$s['date']."\"></input></td>
											<td><input type=\"number\" id=\"inputHeure".$s['stripe_id']."\" value=\"".$s['heure_restante']."\"></input></td>
											<td><input type=\"number\" id=\"inputUser".$s['stripe_id']."\" value=\"".$s['user_id_user']."\" disabled></input></td>
											<td><input type=\"text\" id=\"inputVille".$s['stripe_id']."\" value=\"".$s['user_ville_reference']."\" disabled></input></td>
											<td><input type=\"text\" id=\"inputStripe".$s['stripe_id']."\" value=\"".$s['stripe_id']."\" disabled></input></td>
											<td><button type=\"button\" class=\"btn btn-sm\" onclick=\"modifySous('".$s['stripe_id']."')\">Confirmer</button></td>
											<td><button type=\"button\" class=\"btn btn-sm\" onclick=\"hideInput('SousF".$s['stripe_id']."')\">Annuler</button></td>
										</tr>";
						}
						echo "<br/><tr>
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
						echo "</section>";
        }
      }


    ?>
    <section id="test">
    </section>
  </main>
  <script type="text/javascript" src="js/backOffice.js"></script>
  <script type="text/javascript" src="js/script.js"></script>
</body>
</html>
