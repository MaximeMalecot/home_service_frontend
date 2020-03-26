<?php
	session_start();
	if(isset($_SESSION['langue']) && !empty($_SESSION['langue'])){
		$langue = $_SESSION['langue'];
	}
	$_SESSION = [];
	session_destroy();
	session_start();
	if(isset($langue) && !empty($langue)){
		$_SESSION['langue'] = $langue;
	}
	header('Location: index.php');
	exit();
?>
