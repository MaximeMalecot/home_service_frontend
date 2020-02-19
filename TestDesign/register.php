<!DOCTYPE html>
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
		<section id="fullcontainer">
			<div class="container" id="container">
				<h2> Inscription </h2>
				<br/>
				<?php
				if (isset($_GET['error'])) {
					if ($_GET['error'] == '1'){
						echo "<h3>Les adresses mails ne correspondent pas</h3>";
					}
					if ($_GET['error'] == '2'){
						echo "<h3>Les mots de passe ne correspondent pas</h3>";
					}
					if ($_GET['error'] == '3'){
						echo "<h3>Veuillez remplir tous les champs</h3>";
					}
					if ($_GET['error'] == '4'){
						echo "<h3>L'adresse E-mail est déjà utilisée</h3>";
					}
				}
				?>
				<form id="form_register" method="POST" action="verif_register.php">
					<table>
	         <tr>
	          <td align="right">
	            <label for="pseudo">Nom : </label>
	          </td>
	          <td>
	            <input type="text" placeholder="Votre nom" id="Nom" class="form-control" name="Nom" oninput ="cliquable()" />
	          </td>
	          <td id = "Nom_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="Prenom">Prenom : </label>
	          </td>
	          <td>
	            <input type="text" placeholder="Votre prenom" id="Prenom" class="form-control" name="Prenom" oninput ="cliquable()"/>
	          </td>
	          <td id ="Prenom_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="email">Email : </label>
	          </td>
	          <td>
	            <input type="email" placeholder="Votre mail" id="email" class="form-control" name="email" oninput ="cliquable()"/>
	          </td>
	          <td id ="email_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="email2">Confirmation d'email : </label>
	          </td>
	          <td>
	            <input type="email" placeholder="Confirmez votre email" id="email2" class="form-control" name="email2" oninput ="cliquable()"/>
	          </td>
	          <td id="email2_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="mdp">Mot de passe : </label>
	          </td>
	          <td>
	            <input type="password" placeholder="Votre mot de passe" id="mdp" class="form-control" name="mdp" oninput ="cliquable()"/>
	          </td>
	          <td id="mdp_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="mdp2">Confirmez votre mot de passe : </label>
	          </td>
	          <td>
	            <input type="password" placeholder="Confirmez votre mot de passe" id="mdp2" class="form-control" name="mdp2" oninput ="cliquable()"/>
	          </td>
	          <td id="mdp2_icon">

	          </td>
	        </tr>
				</table></br>
				<?php
		    $x=250;
		    $y=100;
		    $img=imagecreatetruecolor($x,$y);
		    $blanc=imagecolorallocate($img, 255, 255, 255);
		    $orange=imagecolorallocate($img, 220, 100, 0);
		    $bleu=imagecolorallocate($img, 10, 10, 100);
		    $rouge=imagecolorallocate($img, 120, 0, 0);
		    $rose=imagecolorallocate($img, 200, 80, 80);
		    $noir=imagecolorallocate($img, 0, 0, 0);
		    imagefill($img,0,0,$blanc);
		    $couleur=array($orange,$bleu,$rouge,$rose,$noir);
		    $offset=array(-10,0,10);
		    $angle=array(-15,0,15);
		    $taille=array(24,34,44);
		    $police=array("Style/Fonts/AmaticSC-Regular.ttf","Style/Fonts/BalooChettan-Regular.ttf");
		    $chaine=("ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789");
		    $nbr=6;
		    $reponse="";
		    for($i=0;$i<$nbr;$i++){
		     $car=substr($chaine,mt_rand(0,strlen($chaine)-1),1);
		     $reponse .= $car;
		     imagettftext($img,$taille[array_rand($taille)], $angle[array_rand($angle)], $i * ($x / $nbr)
		      +10, $y - 20 + $offset[array_rand($offset)], $couleur[array_rand($couleur)], $police[array_rand($police)], $car);
		   }
		   imagepng($img,"img/myCaptcha.png");
		   $_SESSION['captcha'] = $reponse;
		   ?>
		   <img src="img/myCaptcha.png">
		   <br>
		   <input type="text" name="captcha">
		 </br></br>
		   <input class="btn btn-primary" type="submit" id = 'forminscription'  value="Inscription" />
		 </form>
			</div>
		</section>
		<script type="text/javascript" src="js/script.js"></script>
  </main>
  <?php
    include('footer.php');
  ?>
</body>
</html>
