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
