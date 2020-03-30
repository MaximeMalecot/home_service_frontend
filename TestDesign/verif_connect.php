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


	if( (!isset($_POST['mail'])) || (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) || (!isset($_POST['mdp'])) ){
		echo "<div id=\"errorco\"><p>".$xml->header->myaccount->missing."</p>";
		echo "<button id=\"retry\" onclick=\"connection()\"><h4>".$xml->header->myaccount->errorbutton."</h4></button></div>";
	}

	else{
		$req = $cx->prepare('SELECT * from user where mail = ? and mdp = ?');
		$req->execute(array($_POST['mail'], hash('sha512', $_POST['mdp'])));
		$user = $req->fetch();

		if($user != NULL){
			$_SESSION['mail'] = $_POST['mail'];
			$_SESSION['nom'] = $user['nom'];
			$_SESSION['reservations'] = array();

			$req1=$cx->prepare('SELECT * FROM facturation WHERE id_user = ?');
		  $req1->execute(array($user['id_user']));
		  $factu= $req1->fetchAll();
		  $last = new DateTime($factu[0]['date']);
		  foreach ($factu as $f) {
		    if( new DateTime($f['date']) > $last){
		      $last = new DateTime($f['date']);
		    }
		  }
		  $now = new DateTime();
		  if($last->format('m') < $now->format('m') || $last->format('Y') < $now->format('Y')){
		    $req2 = $cx->prepare('SELECT * FROM souscription WHERE user_id_user = ?');
		    $req2->execute(array($user['id_user']));
		    $sous = $req2->fetch();
		    $req3 = $cx->prepare('SELECT * FROM abonnement WHERE id_abonnement = ?');
		    $req3->execute(array($sous['abonnement_id_abonnement']));
		    $abo = $req3->fetch();
		    $req4 = $cx->prepare('UPDATE souscription SET heure_restante = ? WHERE user_id_user = ?');
		    $req4->execute(array($abo['nb_heure'],$user['id_user']));
		  }

			echo "<section id =\"secondconnect\" class=\"inscription_connexion\">";
			echo "<h3 id=\"goaccount\"><a href='settings.php'>".$xml->header->myaccount->hello.$user['prenom']. "</a></h3>";
			echo "<p id=\"deconnect\"><a href=\"deconnexion.php\">".$xml->header->myaccount->deco."</a></p>
			</section>";
		}
		else{
			echo "<div id=\"errorco\"><p>".$xml->header->myaccount->error."</p>";
			echo "<button id=\"retry\" onclick=\"connection()\"><h4>".$xml->header->myaccount->errorbutton."</h4></button></div>";
		}
	}


?>
