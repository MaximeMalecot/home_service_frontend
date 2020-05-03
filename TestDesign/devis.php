<?php
  require_once "Class/Reservation.php";
  ini_set('display_errors', 1);
  if(isset($_GET['object']) && isset($_SESSION['mail'])){
    $json = json_decode($_GET['object'], true);
    $NewReservation = new Reservation(new DateTime($json['date_debut']['date']),new DateTime($json['date_fin']['date']),$json['nb_unit'],$json['id_supplement'],$json['nb_supplement'],$_SESSION['mail'],$json['prestation_id_prestation'],0);
    $NewReservation->setCout($json['cout']);
    $reqPresta = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $reqPresta->execute(array($NewReservation->getPrestationIdPrestation()));
    $prestation = $reqPresta->fetch();
    $reqInsert = $cx->prepare('INSERT INTO devis(date,cout,date_debut,date_fin,nb_unite,id_supplement,nb_unit_supplement,prestation_id_prestation,prestation_categorie_ville,prestation_categorie_nom,user_id_user,user_ville_reference) VALUES (NOW(),?,?,?,?,?,?,?,?,?,?,?)');
    $reqInsert->execute(array(
        $NewReservation->getCout(),
        $NewReservation->getDateDebut()->format("Y:m:d H:i:s"),
        $NewReservation->getDateFin()->format("Y:m:d H:i:s"),
        $NewReservation->getNbUnit(),
        $NewReservation->getIdSupplement(),
        $NewReservation->getNbSupplement(),
        $NewReservation->getPrestationIdPrestation(),
        $NewReservation->getPrestationVille(),
        $NewReservation->getPrestationCategorie(),
        $NewReservation->getUserIdUser(),
        $NewReservation->getUserVilleReference()
    ));
    echo "<div>
            <h2>Votre devis a bien été enregistré, retrouvez le dans votre espace personnel !</h2>
          </div>";
  }


 ?>
