<?php
  require_once "config.php";
  require_once "requireStripe.php";
  \Stripe\Stripe::setApiKey('sk_test_qMXWSSMoE6DTqXNR7kMQ0k6V00sh4hnDbe');

  ini_set('display_errors', '1');
  if(isset($_SESSION['mail'])){
    require_once "Class/Reservation.php";
    session_start();
  }
  if(strtoupper($_POST['captcha'])!=strtoupper($_SESSION['captcha'])){
    header('Location: register.php?error=Captcha');
    session_destroy();
    die();
  }

  if (isset($_POST['Nom']) && !empty($_POST['Nom'])){
    $nom = htmlspecialchars($_POST['Nom']);
  }
  else{
    header('Location: register.php?error=Nom');
    session_destroy();
    die();
  }

  if (isset($_POST['Prenom']) && !empty($_POST['Prenom'])){
    $prenom = htmlspecialchars($_POST['Prenom']);
  }
  else{
    header('Location: register.php?error=Prenom');
    session_destroy();
    die();
  }

  if (isset($_POST['phone']) && ctype_digit($_POST['phone'])){
    $length = strlen($_POST['phone']);
    if( $length>=10){
      $phone = $_POST['phone'];
    }
  }
  else{
    header('Location: register.php?error=phone');
    session_destroy();
    die();
  }

  if (isset($_POST['addresse'])){
    $addresse = $_POST['addresse'];
  }
  else{
    header('Location: register.php?error=addresse');
    session_destroy();
    die();
  }

  if (isset($_POST['cp']) && ctype_digit($_POST['cp'])){
    $length2 = strlen($_POST['cp']);
    if($length2 == 5){
      $cp = $_POST['cp'];
    }
  }
  else{
    header('Location: register.php?error=cp');
    session_destroy();
    die();
  }

  if (isset($_POST['mail']) && !empty($_POST['mail'])){
    $mail = htmlspecialchars($_POST['mail']);
  }
  else{
    header('Location: register.php?error=mail');
    session_destroy();
    die();
  }

  $req = $cx->prepare('SELECT Prenom FROM user WHERE mail = :mail');
  $req->execute(array('mail' => $mail));

  $answers= [];
  while($user = $req->fetch()){
    $answers [] = $user;
  }
  if (count($answers) != 0){
    header('Location: register.php?error=mail_taken');
    session_destroy();
    die();
  }

  if (isset($_POST['mail2']) && !empty($_POST['mail2'])){
    $mail2 = htmlspecialchars($_POST['mail2']);
  }
  else{
    header('Location: register.php?error=mail2');
    session_destroy();
    die();
  }

  if (isset($_POST['mdp']) && !empty($_POST['mdp'])){
    $mdp = hash('sha512',$_POST['mdp']);
  }
  else{
    header('Location: register.php?error=mdp');
    session_destroy();
    die();
  }

  if (isset($_POST['mdp2']) && !empty($_POST['mdp2'])){
    $mdp2 = hash('sha512',$_POST['mdp2']);
  }
  else{
    header('Location: register.php?error=mdp2');
    session_destroy();
    die();
  }

  if($mail != $mail2){
    header('Location: register.php?error=mail');
    session_destroy();
    die();
  }

  if($mdp != $mdp2){
    header('Location: register.php?error=mdp');
    session_destroy();
    die();
  }
  /*$sender = 'boopursr@services.com';
  $recipient = $mail;
  $subject = "Verification de votre user BoopUrSR";
  $key = md5(microtime(TRUE)*100000);
  $link = "http://51.77.159.247/activation.php?log=".urlencode($prenom) . "&key=" . urlencode($key) ;
  $message = "Merci d'avoir créé un user sur BoopUrSR !

  Profitez dès maintenant de notre site en validant votre e-mail. Cliquez simplement sur ce lien : " . $link . "

  Ceci est un e-mail automatique, merci de ne pas y répondre.";*/

  /*$headers = 'From:' . $sender;
  mail($recipient, $subject, $message, $headers);*/
  $user = \Stripe\Customer::create([
    "email"=> $mail,
    "name"=> $nom,
    "phone"=> $phone,
  ]);
  $take = $cx -> prepare("INSERT INTO user(ville_reference,nom,prenom,mdp,mail,date_inscription,phone,adresse,cp,stripe_id)VALUES(?,?,?,?,?,NOW(),?,?,?,?)");
  $take -> execute(array(
    VILLE,
    $nom,
    $prenom,
    $mdp,
    $mail,
    $phone,
    $addresse,
    $cp,
    $user->id
  ));

  unset($_SESSION['captcha']);
  $_SESSION['mail'] = $_POST['mail'];
  $_SESSION['nom'] = $_POST['nom'];
  $_SESSION['reservations'] = array();
  header('Location: index.php');
  exit;

?>
