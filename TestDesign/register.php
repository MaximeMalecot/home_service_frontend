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
				} ?>

				<h2><?php echo $xml->main->register->title; ?> </h2>
				<br/>
				<?php
				echo "<style>
					#connect{ visibility: hidden;}
				</style>";
				if (isset($_GET['error'])) {
					echo "<style>
						#".$_GET['error']."{ border: 1px solid red; }
					</style>";
				}
				?>
				<form id="form_register" method="POST" action="verif_register.php">
					<table>
	         <tr>
	          <td align="right">
	            <label for="pseudo"><?php echo $xml->main->register->nom; ?> </label>
	          </td>
	          <td>
	            <input type="text" placeholder="<?php echo $xml->main->register->Unom; ?>" id="Nom" class="form-control" name="Nom" />
	          </td>
	          <td id = "Nom_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="Prenom"><?php echo $xml->main->register->prenom; ?></label>
	          </td>
	          <td>
	            <input type="text" placeholder="<?php echo $xml->main->register->Uprenom; ?>" id="Prenom" class="form-control" name="Prenom"/>
	          </td>
	          <td id ="Prenom_icon">

	          </td>
	        </tr>
					<tr>
						<td align="right">
							<label for="phone"><?php echo $xml->main->register->num; ?></label>
						</td>
						<td>
							<input type="text" placeholder="<?php echo $xml->main->register->Unum; ?>" id="phone" class="form-control" name="phone"/>
						</td>
						<td id ="phone_icon">

						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="addresse"><?php echo $xml->main->register->adr; ?></label>
						</td>
						<td>
							<input type="text" placeholder="<?php echo $xml->main->register->Uadr; ?>" id="addresse" class="form-control" name="addresse"/>
						</td>
						<td id ="addresse_icon">

						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="code postal"><?php echo $xml->main->register->cp; ?></label>
						</td>
						<td>
							<input type="text" placeholder="<?php echo $xml->main->register->Ucp; ?>" id="cp" class="form-control" name="cp"/>
						</td>
						<td id ="addresse_icon">

						</td>
					</tr>
	        <tr>
	          <td align="right">
	            <label for="email"><?php echo $xml->main->register->mail; ?></label>
	          </td>
	          <td>
	            <input type="email" placeholder="<?php echo $xml->main->register->Umail; ?>" id="mail" class="form-control" name="mail"/>
	          </td>
	          <td id ="email_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="email2"><?php echo $xml->main->register->mail2; ?></label>
	          </td>
	          <td>
	            <input type="email" placeholder="<?php echo $xml->main->register->Umail2; ?>" id="mail2" class="form-control" name="mail2"/>
	          </td>
	          <td id="email2_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="mdp"><?php echo $xml->main->register->pwd; ?></label>
	          </td>
	          <td>
	            <input type="password" placeholder="<?php echo $xml->main->register->Upwd; ?>" id="mdp" class="form-control" name="mdp"/>
	          </td>
	          <td id="mdp_icon">

	          </td>
	        </tr>
	        <tr>
	          <td align="right">
	            <label for="mdp2"><?php echo $xml->main->register->pwd2; ?></label>
	          </td>
	          <td>
	            <input type="password" placeholder="<?php echo $xml->main->register->Upwd2; ?>" id="mdp2" class="form-control" name="mdp2"/>
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
		   <input type="text" id="Captcha" name="captcha">
		 </br></br>
		   <input class="btn btn-primary" type="submit" id = 'forminscription'  value="<?php echo $xml->main->register->finalbtn; ?>" />
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
