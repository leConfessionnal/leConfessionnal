<?php

class Playlist{

   private $id = null;
   private $date = null;
   private $titre = null;
   private $miniature = array();
   
   public function Playlist(){}

   public function getId() {return $this->id;}
   public function getDate() {return $this->date;}
   public function getTitre() {return $this->titre;}
   public function getMiniature() {return $this->miniature;}

   public function setId($id) {$this->id = $id;}
   public function setDate($date) {$this->date = $date;}
   public function setTitre($titre) {$this->titre = $titre;}
   public function setMiniature($miniature) {$this->miniature = $miniature;}

}
?>