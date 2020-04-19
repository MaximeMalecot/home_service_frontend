<?php

  include( __DIR__ . "/../config.php");
  ini_set('display_errors', 1);

  class Reservation implements JsonSerializable {

    ////////////////ATTRIBUTS POUR LA TABLE RESERVATION : //////////////
    private $date_debut;
    private $date_fin;
    private $nb_unit;
    private $id_supplement;
    private $nb_supplement;
    private $user_id_user;
    private $user_ville_reference;
    private $user_stripe_id;
    private $prestation_id_prestation;
    private $prestation_ville;

    //////////////ATTRIBUTS POUR LA TABLE FACTURATION /////////////////
    private $cout;
    private $prestataire_id;
    private $prestataire_ville;

    public function __construct(DateTime $dd, DateTime $df, float $h, ?int $idsup, ?int $sup, string $m, int $pid, int $prestataire)
    {
      ////////////RESERVE//////////////
      $this->date_debut = $dd;
      $this->date_fin = $df;
      $this->nb_unit = $h;
      $this->id_supplement = $idsup;
      $this->nb_supplement = $sup;
      $this->setUser($m);
      $this->setPresta($pid);
      $this->setPrestataire($prestataire);
    }

    public function setUser(string $mail):void{
      global $cx;
      $req = $cx->prepare('SELECT * FROM user WHERE mail = ?');
      $req->execute(array($mail));
      $user = $req->fetch();

      $this->user_id_user = $user['id_user'];
      $this->user_ville_reference = $user['ville_reference'];
      $this->user_stripe_id = $user['stripe_id'];
    }

    public function setPresta(int $idp):void{
      global $cx;
      $reqPresta = $cx->prepare('SELECT * FROM prestation WHERE id_prestation = ?');
      $reqPresta ->execute(array($idp));
      $presta = $reqPresta ->fetch();

      $this->prestation_id_prestation = $idp;
      $this->prestation_ville = $presta['categorie_ville'];

    }

    public function setPrestataire(int $id):void{
      global $cx;
      $req1 = $cx->prepare('SELECT * FROM prestataire WHERE id_prestataire = ?');
      $req1->execute(array($id));
      $prestataire = $req1->fetch();

      $this->prestataire_id = $prestataire['id_prestataire'];
      $this->prestataire_ville = $prestataire['categorie_ville'];
    }


    public function setManCout(int $idb):void{
      global $cx;
      $reqBar = $cx->prepare('SELECT * FROM bareme WHERE id_bareme = ?');
      $reqBar->execute(array($idb));
      $bareme = $reqBar->fetch();
      if($this->id_supplement != null){
        $reqSup = $cx->prepare('SELECT * FROM supplement WHERE bareme_id_bareme = ?');
        $reqSup->execute(array($bareme['id_bareme']));
        $supplement = $reqSup->fetch();

        if(strcmp($this->date_debut,$this->date_fin) == 0){
          $this->cout = ($this->nb_unit * $bareme['prix_unite']) + ($this->nb_supplement * $supplement['prix_unite']);
        }
        else{
          $nbJoursTime = strtotime($this->date_fin) - strtotime($this->date_debut);
          $nbJours = ($nbJoursTime/86400) + 1;
          $this->cout = (($this->nb_unit * $bareme['prix_unit_recurrent']) * $nbJours) + ($this->nb_supplement * $supplement['prix_unite']);
        }
      }
      else{
        if(strcmp($this->date_debut->format("Y-m-d"),$this->date_fin->format("Y-m-d")) == 0){
          $this->cout = ($this->nb_unit * $bareme['prix_unite']);
        }
        else{
          $nbJoursTime = strtotime($this->date_fin->format("Y-m-d")) - strtotime($this->date_debut->format("Y-m-d"));
          $nbJours = ($nbJoursTime/86400) + 1;
          $this->cout = (($this->nb_unit * $bareme['prix_unit_recurrent']) * $nbJours);
        }
      }
    }

//////////////////NORMAL GETTER AND SETTER/////////////////////////

      public function getDateDebut()
      {
      return $this->date_debut;
      }

      public function setDateDebut($date_debut)
      {
      $this->date_debut = $date_debut;

      return $this;
      }

      public function getDateFin()
      {
      return $this->date_fin;
      }

      public function setDateFin($date_fin)
      {
      $this->date_fin = $date_fin;

      return $this;
      }

      public function getNbUnit()
      {
      return $this->nb_unit;
      }

      public function setNbUnit($nb_unit)
      {
      $this->nb_unit = $nb_unit;

      return $this;
      }

      public function getIdSupplement()
      {
      return $this->id_supplement;
      }

      public function setIdSupplement($id_supplement)
      {
      $this->id_supplement = $id_supplement;

      return $this;
      }

      public function getNbSupplement()
      {
      return $this->nb_supplement;
      }

      public function setNbSupplement($nb_supplement)
      {
      $this->nb_supplement = $nb_supplement;

      return $this;
      }

      public function getUserIdUser()
      {
      return $this->user_id_user;
      }

      public function setUserIdUser($user_id_user)
      {
      $this->user_id_user = $user_id_user;

      return $this;
      }

      public function getUserVilleReference()
      {
      return $this->user_ville_reference;
      }

      public function setUserVilleReference($user_ville_reference)
      {
      $this->user_ville_reference = $user_ville_reference;

      return $this;
      }

      public function getUserStripeId()
      {
      return $this->user_stripe_id;
      }

      public function setUserStripeId($user_stripe_id)
      {
      $this->user_stripe_id = $user_stripe_id;

      return $this;
      }

      public function getPrestationIdPrestation()
      {
      return $this->prestation_id_prestation;
      }

      public function setPrestationIdPrestation($prestation_id_prestation)
      {
      $this->prestation_id_prestation = $prestation_id_prestation;

      return $this;
      }

      public function getPrestationVille()
      {
      return $this->prestation_ville;
      }

      public function setPrestationVille($prestation_ville)
      {
      $this->prestation_ville = $prestation_ville;

      return $this;
      }

      public function getCout()
      {
      return $this->cout;
      }

      public function setCout($cout)
      {
      $this->cout = $cout;

      return $this;
      }

      public function getPrestataireId()
      {
      return $this->prestataire_id;
      }

      public function setPrestataireId($prestataire_id)
      {
      $this->prestataire_id = $prestataire_id;

      return $this;
      }

      public function getPrestataireVille()
      {
      return $this->prestataire_ville;
      }

      public function setPrestataireVille($prestataire_ville)
      {
      $this->prestataire_ville = $prestataire_ville;

      return $this;
      }


/////////////////////////////JSON SERIALIAZ////////////////////////
    public function jsonSerialize()
      {
          return
          [
              'date_debut' => $this->date_debut,
              'date_fin' => $this->date_fin,
              'nb_unit'   => $this->nb_unit,
              'id_supplement' => $this->id_supplement,
              'nb_supplement' => $this->nb_supplement,
              'user_id_user' => $this->user_id_user,
              'user_ville_reference' => $this->user_ville_reference,
              'user_stripe_id' => $this->user_stripe_id,
              'prestation_id_prestation' => $this->prestation_id_prestation,
              'prestation_ville' => $this->prestation_ville,
              'cout' => $this->cout,
              'prestataire_id' => $this->prestataire_id,
              'prestataire_ville' => $this->prestataire_ville,

          ];
      }



      }


?>
