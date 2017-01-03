<?php
class Video{

   private $id = null;
   private $date = null;   
   private $titre = null;
   private $description = null;
   private $miniature = array();
   
   private $playlist = null;
   private $channel = null;
      
   public function Video(){}

   public function getId() {return $this->id;}
   public function getDate() {return $this->date;}
   public function getTitre() {return $this->titre;}
   public function getDescription() {return $this->description;}
   public function getMiniature() {return $this->miniature;}
   public function getPlaylist() {return $this->playlist;}
   public function getChannel() {return $this->channel;}

   public function setId($id) {$this->id = $id;}
   public function setDate($date) {$this->date = $date;}
   public function setTitre($titre) {$this->titre = $titre;}
   public function setDescription($description) {$this->description = $description;}
   public function setMiniature($miniature) {$this->miniature = $miniature;}
   public function setPlaylist($playlist) {$this->playlist = $playlist;}
   public function setChannel($channel) {$this->channel = $channel;}

}
?>