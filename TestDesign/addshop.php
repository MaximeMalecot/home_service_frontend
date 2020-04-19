<?php
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);
  if(isset($_GET['object']) && isset($_SESSION['mail'])){
    $json = json_decode($_GET['object'], true);
    $NewReservation = new Reservation(new DateTime($json['date_debut']['date']),new DateTime($json['date_fin']['date']),$json['nb_unit'],$json['id_supplement'],$json['nb_supplement'],$_SESSION['mail'],$json['prestation_id_prestation'],$json['prestataire_id']);
    $NewReservation->setCout($json['cout']);
    $NewResdd = $NewReservation->getDateDebut();
    $NewResdf = $NewReservation->getDateFin();
    $equal = 0;
    $i = 0;
    if(count($_SESSION['reservations']) === 0){
      array_push($_SESSION['reservations'], serialize($NewReservation));
      echo "<br/>Votre prestation a bien été ajoutés au panier ! Vous avez actuellement ".count($_SESSION['reservations'])." prestations dans votre panier<br/>";
      die();
    }
    foreach ($_SESSION['reservations'] as $res){
      $rez = unserialize($res);
      $rezdd = $rez->getDateDebut();
      $rezdf = $rez->getDateFin();

      if($NewResdd >= $rezdd && $NewResdd <= $rezdf && $NewResdf >= $rezdd){
        echo "<div>
                <h1>Vous aviez déjà une prestation avec des paramètres similaires :</h1><br />
                <h3>Date début :".$rezdd->format("d-m-Y")."</h3>
                <h3>Date fin :".$rezdf->format("d-m-Y")."</h3>
                <h3>Heure début :".$rezdd->format("H:i:s")."</h3>
                <h3>Nombre d'unités :".$rez->getNbUnit()."</h3>
                <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"replace('".htmlspecialchars(json_encode($NewReservation))."', '".$i."')\">Remplacer</button>
              </div>";
      }
      else if($NewResdf <= $rezdf && $NewResdf >= $rezdd && $NewResdd <= $rezdd){
        echo "<div>
                <h1>Vous aviez déjà une prestation avec des paramètres similaires :</h1><br />
                <h3>Date début :".$rezdd->format("d-m-Y")."</h3>
                <h3>Date fin :".$rezdf->format("d-m-Y")."</h3>
                <h3>Heure début :".$rezdd->format("H:i:s")."</h3>
                <h3>Nombre d'unités :".$rez->getNbUnit()."</h3>
                <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"replace('".htmlspecialchars(json_encode($NewReservation))."', '".$i."')\">Remplacer</button>
              </div>";
      }
      else if($NewResdd >= $rezdd && $NewResdd <= $rezdf && $NewResdf >=$rezdd && $NewResdf <= $rezdf){
        echo "<div>
                <h1>Vous aviez déjà une prestation avec des paramètres similaires :</h1><br />
                <h3>Date début :".$rezdd->format("d-m-Y")."</h3>
                <h3>Date fin :".$rezdf->format("d-m-Y")."</h3>
                <h3>Heure début :".$rezdd->format("H:i:s")."</h3>
                <h3>Nombre d'unités :".$rez->getNbUnit()."</h3>
                <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"replace('".htmlspecialchars(json_encode($NewReservation))."', '".$i."')\">Remplacer</button>
              </div>";
      }
      else{
          array_push($_SESSION['reservations'], serialize($NewReservation));
          echo "<br/>Votre prestation a bien été ajoutés au panier ! Vous avez actuellement ".count($_SESSION['reservations'])." prestations dans votre panier<br/>";
      }
      echo "<br />";
      $i+=1;
    }
  }
  else{
    echo "<h3>déconnection ou réservation non trouvée</h3>";
  }

?>
<script type="text/javascript" src="js/script.js"></script>
