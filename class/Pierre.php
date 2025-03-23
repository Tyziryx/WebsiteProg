<?php
// Namespace des classes de mon digramme de classe
namespace classe;

class Pierre {
    public $nom_pierre;
    public $description;
    public $rarete;
    public $image;

    public function __construct($nom_pierre='', $description='', $image='', $rarete='') {
        $this->nom_pierre = $nom_pierre;
        $this->description = $description;
        $this->image = $image;
        $this->rarete = $rarete;
    }

    public function getNomPierre() {
        return $this->nom_pierre;
    }

    public function setNomPierre($val) {
        $this->nom_pierre = $val;
    }
    
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($val) {
        $this->description = $val;
    }
    
    public function getRarete() {
        return $this->rarete;
    }

    public function setRarete($val) {
        $this->rarete = $val;
    }
    
    public function getImage() {
        return $this->image;
    }

    public function setImage($val) {
        $this->image = $val;
    }
}
?>