<?php
  require_once "Class/MYPDF.php";
  require_once "config.php";

  if(isset($_SESSION['mail']) && $_GET['id']){
    $_SESSION['mail'];
    $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
    $req->execute(array($_SESSION['mail']));
    $user = $req->fetch();

    $req1 = $cx->prepare('SELECT * FROM facturation WHERE id_facturation = ?');
    $req1->execute(array($_GET['id']));
    $facture = $req1->fetch();
    $req2= $cx->prepare('SELECT * FROM reservation WHERE id_reservation = ? ');
    $req2->execute(array($facture['reservation_id_reservation']));
    $reserv = $req2->fetch();
    $req3 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ? ');
    $req3->execute(array($reserv['prestation_id_prestation']));
    $presta = $req3->fetch();


    // create new PDF document
    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('HomeService');
    $pdf->SetTitle("Facture");
    $pdf->SetSubject('TCPDF Tutorial');
    $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

    // set default header data
    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
    $pdf->setFooterData(array(0,64,0), array(0,64,128));

    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    // set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

    // set image scale factor
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    // set default font subsetting mode
    $pdf->setFontSubsetting(true);

    // Set font
    // dejavusans is a UTF-8 Unicode font, if you only need to
    // print standard ASCII chars, you can use core fonts like
    // helvetica or times to reduce file size.
    $pdf->SetFont('helvetica', '', 14, '', true);

    // Add a page
    // This method has several options, check the source code documentation for more information.
    $pdf->AddPage();


    // set text shadow effect
    $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
    // Set some content to print
    if(strcmp($reserv['date_debut'], $reserv['date_fin']) != 0){
      $html = '
        <h1>Welcome to <a href="index.php"><img src="img/logo.png" height="50px" id="logo"></a></h1>'.
        '<ul>'.
          '<li>Payeur : '.$user['nom']." ".$user['prenom'].'</li>'.
          '<li>Adresse mail : '.$user['mail'].'</li>'.
          '<li>Facture pour la prestation : '.$presta['nom'].'</li>'.
          '<li>Prestation prise le : '.$facture['date'].'</li>'.
          '<li>Date de début de la prestation : '.$reserv['date_debut'].'</li>'.
          '<li>Date de fin de la prestation : '.$reserv['date_fin'].'</li>'.
          '<li>Prix de la prestation : '.$facture['cout'].' €</li>'.
          '<li>Destinataire : HomeService '.$presta['categorie_ville'].'</li>'.
        '</ul>';
      }
      else{
        $html = '
          <h1>Welcome to <a href="index.php"><img src="img/logo.png" height="50px" id="logo"></a></h1>'.
          '<ul>'.
            '<li>Payeur : '.$user['nom']." ".$user['prenom'].'</li>'.
            '<li>Adresse mail : '.$user['mail'].'</li>'.
            '<li>Facture pour la prestation : '.$presta['nom'].'</li>'.
            '<li>Prestation prise le : '.$facture['date'].'</li>'.
            '<li>Date pour la prestation : '.$reserv['date_debut'].'</li>'.
            '<li>Prix de la prestation : '.$facture['cout'].' €</li>'.
            '<li>Destinataire : HomeService '.$presta['categorie_ville'].'</li>'.
          '</ul>';
      }
      $pdf->writeHTML($html, true, false, true, false, '');

      $pdf->Output('facturation_'.$facture['id_facturation'].'.pdf', 'I');
  }
?>
