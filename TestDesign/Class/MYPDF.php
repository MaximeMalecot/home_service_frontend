<?php

  include( __DIR__ . "/../config.php");
  require_once "TCPDF/tcpdf.php";
  class MYPDF extends TCPDF {

      //Page header
      public function Header() {
          // Logo
          $image_file = K_PATH_IMAGES.'logo_example.jpg';
          $this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
          // Set font
          $this->SetFont('helvetica', 'B', 20);
          // Title
          $this->Cell(0, 15, 'Home Service thanks you !', 0, false, 'C', 0, '', 0, false, 'M', 'M');
      }

      // Page footer
      public function Footer() {
          // Position at 15 mm from bottom
          $this->SetY(-15);
          // Set font
          $this->SetFont('helvetica', 'I', 8);
          // Page number
          $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      }
  }
  /*
  $_SESSION['mail'];
  $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
  $req->execute(array($_SESSION['mail']));
  $user = $req->fetch();

  $req1 = $cx->prepare('SELECT * FROM facturation WHERE id_facturation = ?');
  $req1->execute(array(20));
  $facture = $req1->fetch();
  $req2= $cx->prepare('SELECT * FROM reservation WHERE id_reservation = ? ');
  $req2->execute(array($facture['reservation_id_reservation']));
  $reserv = $req2->fetch();
  $req3 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ? ');
  $req3->execute(array($reserv['prestation_id_prestation']));
  $presta = $req3->fetch();
  */
  /*if(strcmp($reserv['date_debut'], $reserv['date_fin']) != 0){
    '<li>Date de début de la prestation : '.$reserv['date_debut'].'</li>'.
    '<li>Date de fin de la prestation : '.$reserv['date_fin'].'</li>'.
  }
  else{
    '<li>Date pour la prestation : '.$reserv['date_debut'].'</li>'.
  }*/
?>
