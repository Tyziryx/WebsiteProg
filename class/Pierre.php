<?php
// Namespace des classes de mon digramme de classe
// Vous devez implémanter des methodes magiques
namespace classe;

class Pierre{
    private $nom;
    public $description;
    public $photo;
    public $rarete;

    public function __construct($nom='', $desc='', $pto='', $rarete=''){
        $this->rarete = $rarete;
        $this->nom = $nom;
        $this->description = $desc;
        $this->photo = $pto;

    }

    public function getNom(){
        return $this->nom;
    }

    public function setNom($val){
        $this->nom = $val;
    }

}



?>