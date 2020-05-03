<?php
  require_once "Class/Reservation.php";
  require_once "config.php";
  require_once "functions.php";

  if(isset($_POST['unit']) && !empty($_POST['unit'])){
    $unit = $_POST['unit'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if(isset($_POST['dd']) && !empty($_POST['dd'])){
    $date_debut = $_POST['dd'];
  }
  else{
    echo "Tous les champs n'était pas remplis";
    die();
  }

  if($_POST['type'] == 2){
    if(isset($_POST['df']) && !empty($_POST['df'])){
      $date_fin = $_POST['df'];
    }
    else{
      echo "Tous les champs n'était pas remplis";
      die();
    }
  }

  if(isset($_POST['sup']) && !empty($_POST['sup'])){
    $nb_supplement = $_POST['sup'];
  }
  else{
    $nb_supplement = 0;
  }

  if($_POST['type'] != 2){
    $date_fin = $date_debut;
  }

  if(isset($_POST['bareme']) && !empty($_POST['bareme'])){
    $req = $cx->prepare('SELECT * FROM bareme WHERE id_bareme = ?');
    $req->execute(array($_POST['bareme']));
    $bareme = $req->fetch();
    $req1 = $cx->prepare('SELECT * FROM supplement WHERE bareme_id_bareme = ?');
    $req1->execute(array($bareme['id_bareme']));
    $supplement = $req1->fetch();
    if($bareme == NULL){
      echo "Une erreur est survenue !";
    }
  }
  else{
    echo "Une erreur est survenue !";
  }


  if(isset($_SESSION['mail'])){
    $req2 = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
    $req2->execute(array($_POST['id']));
    $prestation = $req2->fetch();
    $reqAffect = $cx->prepare('SELECT * FROM affectation WHERE prestation_id_prestation = ?');
    $reqAffect->execute(array($_POST['id']));
    $affectations = $reqAffect->fetchAll();

    if($date_debut != $date_fin){
          $pres_dispo = array();
          $rdd = DateTime::createFromFormat("Y-m-d", $date_debut);//date_debut format DateTime
          $rdf = DateTime::createFromFormat("Y-m-d", $date_fin);//$date_fin format DateTime
          $rdi = DateTime::createFromFormat("Y-m-d", $date_debut);//date_debut format DateTime utilisée pour incrémenter dans les boucles


          $totaltime = $unit * $bareme['time_per_unit'];////Récupère le temps nécessaire avec le temps pour l'unité et le nombre d'unité
          $hd = new DateTime ($_POST['time']);//Récupère l'heure de début
          $hf = new DateTime ($_POST['time']);//Mets une datetime égale à l'heure de début
          $hf->modify("+".$totaltime." hours");//Ajoute le temps nécessaire à l'heure du début pour avoir l'heure de fin

          $Jours = $rdd->diff($rdf);//nbJours->days = LA DIFFERENCE DE JOURS ENTRE LES DEUX DATES
          $nbJours = $Jours->days + 1;
          $allDays = array();

          while ($rdi <= $rdf){
            array_push($allDays, $rdi->format("Y-m-d"));
            $rdi->modify("+1 day");
          }

          $Query = prepareQuery($allDays, "SELECT TIME(date_debut), TIME(date_fin), prestataire_id_prestataire FROM planning WHERE DATE(date_debut) IN (", "DATE", ") AND prestataire_id_prestataire = ?");
          $nbArgs = count($allDays);
          $i = 0;
          $reqJours = $cx->prepare($Query);
          foreach($affectations as $a){
            $allDays[$nbArgs] = $a['prestataire_id_prestataire'];
            $reqJours->execute($allDays);
            $Jours = $reqJours->fetchAll();

            if(count($Jours) == $nbJours){
              foreach($Jours as $j){
                if($j['TIME(date_debut)'] < $hd->format('H:i:s') && $j['TIME(date_fin)'] >  $hf->format('H:i:s')){
                    $i+=1;
                }
              }
              if($i === count($allDays) - 1){
                array_push($pres_dispo, $a['prestataire_id_prestataire']);
              }
            }
            $i = 0;

          }

          if(count($pres_dispo) === 0){
            echo "<h3>Malheureusement aucun de nos prestataire ne sera disponible pour vous à ces horaires-ci</h3>";
            $rdd ->setTime($hd->format("H"),$hd->format("i"),$hd->format("s"));
            $rdf->setTime($hf->format("H"),$hf->format("i"),$hf->format("s"));

            $reserv = new Reservation($rdd,$rdf,$unit,$supplement['id_supplement'],$nb_supplement,$_SESSION['mail'],$prestation['id_prestation'], 0);
            $reserv->setManCout($bareme['id_bareme']);

            echo "<div>
                    <h2>Votre prestation vous couterais : ".$reserv->getCout()." €</h2>
                    <button id=\"btnDevis\" class=\"btn btn-primary\" onclick=\"devis('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Enregister un devis</button>
                  </div>
                  ";
          }
          else{
            $Query = prepareQuery($pres_dispo, "SELECT id_prestataire FROM prestataire WHERE prix_recurrent = (SELECT MIN(prix_recurrent) FROM prestataire WHERE id_prestataire IN (", null, ") ".prepareQuery($pres_dispo,"AND id_prestataire IN (",null,"))"), ") ");
            foreach($pres_dispo as $p){
              array_push($pres_dispo,$p);
            }
            $reqFinalPresta = $cx->prepare($Query);
            $reqFinalPresta->execute($pres_dispo);
            $Prestataire = $reqFinalPresta->fetch();


            $rdd ->setTime($hd->format("H"),$hd->format("i"),$hd->format("s"));
            $rdf->setTime($hf->format("H"),$hf->format("i"),$hf->format("s"));

            $reserv = new Reservation($rdd,$rdf,$unit,$supplement['id_supplement'],$nb_supplement,$_SESSION['mail'],$prestation['id_prestation'], $Prestataire['id_prestataire']);
            $reserv->setManCout($bareme['id_bareme']);
            if($reserv->getCout() > 0){
              echo "<div>
                      <h2>Votre prestation vous couterais : ".$reserv->getCout()." €</h2>
                      <button id=\"btnDevis\" class=\"btn btn-primary\" onclick=\"addshop('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Ajouter au panier</button>
                      <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"devis('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Enregister un devis</button>
                    </div>
                    ";
            }
            else{
              echo "<h2>Il y a eu une erreur dans vos dates, réessayez</h2>";
            }
          }

    }
    else{
      $pres_dispo = array();
      $rdd = DateTime::createFromFormat("Y-m-d", $date_debut);//date_debut format DateTime
      $rdf = DateTime::createFromFormat("Y-m-d", $date_fin);//$date_fin format DateTime

      $totaltime = $unit * $bareme['time_per_unit'];
      $hd = new DateTime ($_POST['time']);//Récupère l'heure de début
      $hf = new DateTime ($_POST['time']);//Mets une datetime égale à l'heure de début
      $hf->modify("+".$totaltime." hours");//Ajoute le temps nécessaire à l'heure du début pour avoir l'heure de fin

      $Query= "SELECT TIME(date_debut), TIME(date_fin), prestataire_id_prestataire FROM planning WHERE DATE(date_debut) IN (DATE(?)) AND  prestataire_id_prestataire = ?";
      $reqJours= $cx->prepare($Query);

      foreach($affectations as $a){

        $reqJours->execute(array(
          $rdd->format("Y-m-d"),
          $a['prestataire_id_prestataire']
        ));
        $Jours = $reqJours->fetch();
        if($Jours['TIME(date_debut)'] < $hd->format('H:i:s') && $Jours['TIME(date_fin)'] >  $hf->format('H:i:s')){
          array_push($pres_dispo, $a['prestataire_id_prestataire']);
        }
      }
      if(count($pres_dispo) === 0){
        echo "<h3>Malheureusement aucun de nos prestataire ne sera disponible pour vous à ces horaires-ci</h3>";

        $rdd ->setTime($hd->format("H"),$hd->format("i"),$hd->format("s"));
        $rdf->setTime($hf->format("H"),$hf->format("i"),$hf->format("s"));

        $reserv = new Reservation($rdd,$rdf,$unit,$supplement['id_supplement'],$nb_supplement,$_SESSION['mail'],$prestation['id_prestation'], 0);
        $reserv->setManCout($bareme['id_bareme']);
      }
      else{
        $Query = prepareQuery($pres_dispo, "SELECT id_prestataire FROM prestataire WHERE prix_recurrent = (SELECT MIN(prix_recurrent) FROM prestataire WHERE id_prestataire IN (", null, ") ".prepareQuery($pres_dispo,"AND id_prestataire IN (",null,"))"), ") ");
        foreach($pres_dispo as $p){
          array_push($pres_dispo,$p);
        }
        $reqFinalPresta = $cx->prepare($Query);
        $reqFinalPresta->execute($pres_dispo);
        $Prestataire = $reqFinalPresta->fetch();

        $rdd ->setTime($hd->format("H"),$hd->format("i"),$hd->format("s"));
        $rdf->setTime($hf->format("H"),$hf->format("i"),$hf->format("s"));

        $reserv = new Reservation($rdd,$rdf,$unit,$supplement['id_supplement'],$nb_supplement,$_SESSION['mail'],$prestation['id_prestation'], $Prestataire['id_prestataire']);
        $reserv->setManCout($bareme['id_bareme']);
        if($reserv->getCout() > 0){
          echo "<div>
                  <h2>Votre prestation vous couterais : ".$reserv->getCout()." €</h2>
                  <button id=\"btnDevis\" class=\"btn btn-primary\" onclick=\"devis('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Enregister un devis</button>
                  <button id=\"btnPanl\" class=\"btn btn-primary\" onclick=\"addshop('".htmlspecialchars(json_encode($reserv))."')\" style=\"visibility: visible\">Ajouter au panier</button>
                </div>
                ";
        }
        else{
          echo "<h2>Il y a eu une erreur dans vos dates, réessayez</h2>";
        }
      }
    }
  }
  else{
    echo "connectez vous et vous pourrez réserver !";
  }


?>
<div id="added">

</div>
<script type="text/javascript" src="js/script.js"></script>
