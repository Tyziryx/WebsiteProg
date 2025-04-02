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
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
        throw new Exception("Propriété '$property' introuvable.");
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        } else {
            throw new Exception("Propriété '$property' introuvable.");
        }
    }
}
?>