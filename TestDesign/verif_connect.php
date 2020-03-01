<?php
	include('config.php');
	if(!isset($_POST['mail'])){
		header('Location: index.php?error=mail_missing');
		exit();
	}
	if (!filter_var($_POST['mail'], FILTER_VALIDATE_EMAIL)){
		header('Location: index.php?error=mail_format');
		exit();
	}
	if(!isset($_POST['mdp'])){
		header('Location: index.php?error=no_mdp');
		exit();
	}

	$req = $cx->prepare('SELECT Nom from user where mail = ? and mdp = ?');
	$req->execute(array($_POST['mail'], hash('sha512', $_POST['mdp'])));


	$answers= [];
	while($user = $req->fetch()){
		$Nom = $user['Nom'];
		$answers [] = $user;
	}
	if(count($answers) !=0){
		session_start();
		$_SESSION['mail'] = $_POST['mail'];
		$_SESSION['Nom'] = $Nom;
		header('Location: index.php');
		exit();
	}
	else{
		header('Location: index.php?error=wrong_pswd');
	}


?>
