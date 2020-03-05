<?php
	require_once "config.php";

	if( (!isset($_POST['mail'])) || (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)) || (!isset($_POST['mdp'])) ){
		echo "<div id=\"errorco\"><p>Tous les champs n'étaient pas remplis, veuillez réessayer</p>";
		echo "<button id=\"retry\" onclick=\"connection()\"><h4>Réessayer</h4></button></div>";
	}

	else{
		$req = $cx->prepare('SELECT * from user where mail = ? and mdp = ?');
		$req->execute(array($_POST['mail'], hash('sha512', $_POST['mdp'])));
		$user = $req->fetch();

		if($user != NULL){
			session_start();
			$_SESSION['mail'] = $_POST['mail'];
			$_SESSION['nom'] = $user['nom'];
			echo "<section id =\"secondconnect\" class=\"inscription_connexion\">";
			echo "<h3 id=\"goaccount\"><a href='settings.php'> Bonjour " . $user['prenom'] . "</a></h3>";
			echo "<p id=\"deconnect\"><a href=\"deconnexion.php\">Se déconnecter</a></p>
			</section>";
		}
		else{
			echo "<div id=\"errorco\"><p>Votre email ou mot de passe ne correspond pas, veuillez réessayer</p>";
			echo "<button id=\"retry\" onclick=\"connection()\"><h4>Réessayer</h4></button></div>";
		}
	}


?>
