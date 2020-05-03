<html>
<head>
	<title>Home Service</title>
	<link rel="stylesheet" type="text/css" href="Style/bootstrap.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<script src="https://js.stripe.com/v3/"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<link rel="stylesheet" type="text/css" href="Style/style.css">
	<meta charset="utf-8">
</head>
<body>
	<?php
		include('header.php');
	?>
	<main>
    <?php
      ini_set('display_errors', 1);
      require_once "config.php";
      require_once "Stripe/init.php";
			  require_once "functions.php";
			\Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');
			$pay = 0;

      if(isset($_SESSION['mail'])){
				$req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
				$req->execute(array($_SESSION['mail']));
				$user = $req->fetch();
				$req2 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
				$req2->execute(array($user['id_user']));
				$souscription = $req2->fetch();
				$req3 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
				$req3->execute(array($souscription['abonnement_id_abonnement']));
				$abonnement = $req3->fetch();
				$reqDevis = $cx->prepare('SELECT * FROM devis WHERE user_id_user = ?');
				$reqDevis->execute(array($user['id_user']));
				$devis = $reqDevis->fetchAll();

				if( strcmp($user['statut'], "admin") == 0){
					echo "<h1>Tu es admin, tu peux donc accéder au BACK-OFFICE ICI : </h1>";
					echo "<form action=\"backoffice.php\">
								    <button class=\"btn btn-primary\">Back Office</button>
								</form>";
				}


				if($souscription != null){
					$pay +=1;
					echo "<section id=\"subscription_invoice\">Vos payements suite à votre abonnement sur : ".$abonnement['nom']."<br/>";

					$invoices  = \Stripe\Invoice::all();
					foreach($invoices as $invoice){
						if($invoice->subscription == $souscription['stripe_id']){
							echo "<div>".($invoice->amount_paid/100)."€ le : ";
							$timestamp = $invoice->created;
							echo gmdate("d-m-Y à H:i:s", $timestamp)."</div>";

						}
					}
					echo "</section><br/>";
				}

				$req4 = $cx->prepare('SELECT * FROM reservation WHERE user_id_user = ?	ORDER BY id_reservation DESC');
				$req4->execute(array($user['id_user']));
				$reservations = $req4->fetchAll();
				$req5 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
				$req6 = $cx->prepare('SELECT * FROM facturation WHERE reservation_id_reservation = ?');
				$reqAffect = $cx->prepare('SELECT * FROM affectation WHERE prestation_id_prestation = ?');
				$reqBar = $cx->prepare('SELECT * FROM bareme WHERE id_bareme = ?');

				if($devis != null){
					echo "<section id=\"devis\">Vos devis<br/>";
					$today = new DateTime();
					$reqDelete = $cx->prepare('DELETE FROM devis WHERE idDevis = ?');
					foreach($devis as $d){

						$date_debut = new DateTime($d['date_debut']);
						if($date_debut < $today){
							$reqDelete->execute(array($d['idDevis']));
						}
						else{
							$req5->execute(array($d['prestation_id_prestation']));
							$presta = $req5->fetch();
							$reqAffect->execute(array($d['prestation_id_prestation']));
							$affectations = $reqAffect->fetchAll();
							$reqBar->execute(array($presta['bareme_id_bareme']));
							$bareme = $reqBar->fetch();

							$rdd = DateTime::createFromFormat("Y-m-d H:i:s", $d['date_debut']);//date_debut format DateTime
							$rdf = DateTime::createFromFormat("Y-m-d H:i:s", $d['date_fin']);//$date_fin format DateTime

							echo "<div class=\"histoPresta\">
											Devis pour la prestation : ".$presta['nom']."<br />
											Nombre d'unités : ".$d['nb_unite']."<br />";
											if( strcmp( $rdd->format("Y-m-d"),$rdf->format("Y-m-d")) != 0){
												echo "Date de début de la prestation : ".$d['date_debut']."<br/>".
															"Date de fin de la prestation : ".$d['date_fin']."<br/>";

															$pres_dispo = array();
										          $rdi = DateTime::createFromFormat("Y-m-d H:i:s", $d['date_debut']);//date_debut format DateTime utilisée pour incrémenter dans les boucles

															$totaltime = $d['nb_unite'] * $bareme['time_per_unit'];////Récupère le temps nécessaire avec le temps pour l'unité et le nombre d'unité
															$hd = new DateTime ($rdd->format("H:i:s"));//Récupère l'heure de début
															$hf = new DateTime ($rdf->format("H:i:s"));//Mets une datetime égale à l'heure de début
															$hf->modify("+".$totaltime." hours");//Ajoute le temps nécessaire à l'heure du début pour avoir l'heure de fin

															$Jours = $rdd->diff($rdf);//nbJours->days = LA DIFFERENCE DE JOURS ENTRE LES DEUX DATES
															$nbJours = $Jours->days + 1;
															$allDays = array();

															while ($rdi <= $rdf){
																array_push($allDays, $rdi->format("Y-m-d"));
																$rdi->modify("+1 day");
															}
															$Query = prepareQuery($allDays, "SELECT TIME(date_debut), TIME(date_fin), prestataire_id_prestataire FROM planning WHERE DATE(date_debut) IN (", "DATE", ") AND prestataire_id_prestataire = ?");
										          $nbArgs = count($allDays);
										          $i = 0;
										          $reqJours = $cx->prepare($Query);
										          foreach($affectations as $a){
										            $allDays[$nbArgs] = $a['prestataire_id_prestataire'];
										            $reqJours->execute($allDays);
										            $Jours = $reqJours->fetchAll();

										            if(count($Jours) == $nbJours){
										              foreach($Jours as $j){
										                if($j['TIME(date_debut)'] < $hd->format('H:i:s') && $j['TIME(date_fin)'] >  $hf->format('H:i:s')){
										                    $i+=1;
										                }
										              }
										              if($i === count($allDays) - 1){
										                array_push($pres_dispo, $a['prestataire_id_prestataire']);
										              }
										            }
										            $i = 0;
										          }
											}
											else{
												echo "Date pour la prestation : ".$d['date_debut']."<br/>";

												$pres_dispo = array();

									      $totaltime = $d['nb_unite'] * $bareme['time_per_unit'];
									      $hd = new DateTime ($rdd->format("H:i:s"));//Récupère l'heure de début
									      $hf = new DateTime ($rdf->format("H:i:s"));//Mets une datetime égale à l'heure de début
									      $hf->modify("+".$totaltime." hours");//Ajoute le temps nécessaire à l'heure du début pour avoir l'heure de fin

									      $Query= "SELECT TIME(date_debut), TIME(date_fin), prestataire_id_prestataire FROM planning WHERE DATE(date_debut) IN (DATE(?)) AND  prestataire_id_prestataire = ?";
									      $reqJours= $cx->prepare($Query);

												foreach($affectations as $a){

													$reqJours->execute(array(
														$rdd->format("Y-m-d"),
														$a['prestataire_id_prestataire']
													));
													$Jours = $reqJours->fetch();
													if($Jours['TIME(date_debut)'] < $hd->format('H:i:s') && $Jours['TIME(date_fin)'] >  $hf->format('H:i:s')){
														array_push($pres_dispo, $a['prestataire_id_prestataire']);
													}
												}
												print_r($pres_dispo);
											}

							echo	"Cout : ".$d['cout'];
							if(count($pres_dispo) > 0){
								$Query = prepareQuery($pres_dispo, "SELECT id_prestataire FROM prestataire WHERE prix_recurrent = (SELECT MIN(prix_recurrent) FROM prestataire WHERE id_prestataire IN (", null, ") ".prepareQuery($pres_dispo,"AND id_prestataire IN (",null,"))"), ") ");
								foreach($pres_dispo as $p){
									array_push($pres_dispo,$p);
								}
								$reqFinalPresta = $cx->prepare($Query);
								$reqFinalPresta->execute($pres_dispo);
								$Prestataire = $reqFinalPresta->fetch();


								$reserv = new Reservation($rdd,$rdf,$d['nb_unite'],$d['id_supplement'],$d['nb_unit_supplement'],$_SESSION['mail'],$presta['id_prestation'], $Prestataire['id_prestataire']);
		            $reserv->setManCout($bareme['id_bareme']);
								$cout = (int)$d['cout'];
								try{
									$session = \Stripe\Checkout\Session::create([
		                'customer' => $user['stripe_id'],
		                'payment_method_types' => ['card'],
		                'line_items' => [[
		                  'name' => 'Prestations',
		                  'description' => 'Achat de plusieurs prestations',
		                  'amount' => $cout * 100,
		                  'currency' => 'eur',
		                  'quantity' => 1,
		                ]],
		                'success_url' => URL."/finaldevis.php?session_id={CHECKOUT_SESSION_ID}&object=".serialize($reserv)."&devis=".$d['idDevis'],
		                'cancel_url' => URL."/settings.php?session_id=cancel",
		              ]);
		              echo "<br /><button class=\"btn btn-primary\" onclick=\"gotoCheckout('".$session->id."')\">Procéder au payement</button>";
								}
								catch(Exception $e){
	                break;
	              }
								echo "<br /></div>";
							}
							else{
								echo "<br /></div>";
							}
						}
					}
					echo "</section><br />";

				}

				if($reservations != null){
					$pay +=1;
					echo "<section id=\"Allreserv\">
									Vos prestations prises : ";
					foreach($reservations as $r){

						$req5->execute(array($r['prestation_id_prestation']));
						$presta = $req5->fetch();
						$req6->execute(array($r['id_reservation']));
						$factu = $req6->fetch();
						echo "<div class=\"histoPresta\">
										Reservation de la prestation :".$presta['nom']."<br/>
										Nombre d'unités :".$r['nb_unite']."<br/>";
										if(strcmp($r['date_debut'], $r['date_fin']) != 0){
											echo "Date de début de la prestation : ".$r['date_debut']."<br/>".
														"Date de fin de la prestation : ".$r['date_fin']."<br/>";
										}
										else{
											echo "Date pour la prestation : ".$r['date_debut']."<br/>";
										}
						echo 		"Cout : ".$factu['cout'];
								if($factu['cout'] > 0){
									echo "<br/><a href=\"facture.php?id=".$factu['id_facturation']."\" class=\"button\">Votre facture</a>";
									}
						echo			"</div>";
					}
					echo "</section>";
				}

				if($pay == 0){
					echo "<h1>Cette section contient tous vos payements, malheureusement vous n'avez ni souscrit à un abonnement ni pris de prestations !</h1>";
				}
			}
    ?>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
