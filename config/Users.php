<?php
namespace bd;

use PDO;
use bd\GestionBD;

class User {

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // La requête SQL pour récupérer tous les utilisateurs
        $sql = 'SELECT * FROM utilisateurs';
        $stat = $BD->pdo->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'bd\User');
        $stat->execute();

        // Récupérer tous les utilisateurs sous forme d'objets User
        $users = $stat->fetchAll();
        $BD->deconnexion();

        return $users;
    }

    // Récupérer un utilisateur par pseudo
    public function getUserByPseudo($pseudo) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour récupérer un utilisateur par pseudo
        $sql = 'SELECT * FROM utilisateurs WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'bd\User');
        $stat->execute();

        // Récupérer l'utilisateur sous forme d'objet
        $user = $stat->fetch();
        $BD->deconnexion();

        return $user;
    }

    // Modifier un utilisateur (Nom, email, mot de passe)
    public function updateUser($pseudo, $email, $mot_de_passe) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour modifier un utilisateur
        $sql = 'UPDATE utilisateurs SET email = :email, mot_de_passe = :mot_de_passe WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);

        // Exécuter la requête
        $result = $stat->execute();
        $BD->deconnexion();

        return $result;
    }

    // Supprimer un utilisateur
    public function deleteUser($pseudo) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour supprimer un utilisateur
        $sql = 'DELETE FROM utilisateurs WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

        // Exécuter la requête
        $result = $stat->execute();
        $BD->deconnexion();

        return $result;
    }

    // Passer un utilisateur au rôle admin / non-admin
    public function toggleAdmin($pseudo) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour passer l'utilisateur admin/non-admin
        $sql = 'UPDATE utilisateurs SET admin = NOT admin WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

        // Exécuter la requête
        $result = $stat->execute();
        $BD->deconnexion();

        return $result;
    }

    // Vérifier si un utilisateur est admin
    public function isAdminStatus($pseudo) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour vérifier si l'utilisateur est admin
        $sql = 'SELECT admin FROM utilisateurs WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stat->execute();

        // Récupérer le statut admin
        $isAdmin = $stat->fetchColumn();
        $BD->deconnexion();

        return $isAdmin;
    }
}

?>
