<h2>Abonnements</h2>
<?php
  include('config.php');
  $date = date('Y-m-d H:i:s');
  echo $date;
  $req=$cx->prepare("UPDATE user SET date_inscription = NOW() WHERE id_user = 1");
  $req->execute(array($date));
  echo "ok";
?>
