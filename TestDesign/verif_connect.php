<?php
	include('config.php');
	if(!isset($_POST['email'])){
		header('Location: index.php?error=email_missing');
		exit();
	}
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
		header('Location: index.php?error=email_format');
		exit();
	}
	if(!isset($_POST['mdp'])){
		header('Location: index.php?error=no_mdp');
		exit();
	}

	$req = $cx->prepare('SELECT Nom from User where email = ? and mdp = ?');
	$req->execute(array($_POST['email'], hash('sha512', $_POST['mdp'])));


	$answers= [];
	while($user = $req->fetch()){
		$Nom = $user['Nom'];
		$answers [] = $user;
	}
	if(count($answers) !=0){
		session_start();
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['Nom'] = $Nom;
		header('Location: index.php');
		exit();
	}
	else{
		header('Location: index.php?error=wrong_pswd');
	}


?>
