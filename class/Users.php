<?php
// Namespace des classes de mon diagramme de classe
namespace classe;

class User {
    public $pseudo;
    public $email;
    public $mot_de_passe;
    public $admin;

    // Constructeur pour initialiser l'objet User
    public function __construct($pseudo='', $email='', $admin=false) {
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->admin = $admin;
    }

    // Getter et Setter pour le pseudo
    public function getPseudo() {
        return $this->pseudo;
    }

    public function setPseudo($val) {
        $this->pseudo = $val;
    }

    // Getter et Setter pour l'email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($val) {
        $this->email = $val;
    }

    // Getter et Setter pour le rôle (admin)
    public function isAdmin() {
        return $this->admin;
    }

    public function setAdmin($val) {
        $this->admin = $val;
    }
}
?>
