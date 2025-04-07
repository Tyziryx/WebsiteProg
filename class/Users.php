<?php
// Namespace des classes de mon diagramme de classe
namespace classe;

/**
 * Classe User
 *
 * Représente un utilisateur avec des informations telles que le pseudo, l'email, et le rôle admin.
 * Fournit des méthodes pour accéder et modifier ces informations.
 */
class User {
    /**
     * @var string Le pseudo de l'utilisateur.
     */
    public $pseudo;

    /**
     * @var string L'email de l'utilisateur.
     */
    public $email;

    /**
     * @var bool Le statut admin de l'utilisateur (true si admin, false sinon).
     */
    public $admin;

    /**
     * Constructeur pour initialiser l'objet User.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $email L'email de l'utilisateur.
     * @param bool $admin Le statut admin de l'utilisateur. Par défaut, false.
     */
    public function __construct($pseudo='', $email='', $admin=false) {
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->admin = $admin;
    }

    /**
     * Récupère le pseudo de l'utilisateur.
     *
     * @return string Le pseudo de l'utilisateur.
     */
    public function getPseudo() {
        return $this->pseudo;
    }

    /**
     * Modifie le pseudo de l'utilisateur.
     *
     * @param string $val Le nouveau pseudo de l'utilisateur.
     */
    public function setPseudo($val) {
        $this->pseudo = $val;
    }

    /**
     * Récupère l'email de l'utilisateur.
     *
     * @return string L'email de l'utilisateur.
     */    
    public function getEmail() {
        return $this->email;
    }

    /**
     * Modifie l'email de l'utilisateur.
     *
     * @param string $val Le nouvel email de l'utilisateur.
     */
    public function setEmail($val) {
        $this->email = $val;
    }

    /**
     * Vérifie si l'utilisateur est un administrateur.
     *
     * @return bool true si l'utilisateur est un administrateur, false sinon.
     */
    public function isAdmin() {
        return $this->admin;
    }

    /**
     * Modifie le statut admin de l'utilisateur.
     *
     * @param bool $val Le nouveau statut admin de l'utilisateur.
     */
    public function setAdmin($val) {
        $this->admin = $val;
    }




}




?>
