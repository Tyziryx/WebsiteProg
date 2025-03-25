<?php
namespace bd;

use PDO;
use bd\GestionBD;
require_once __DIR__ . '/GestionBD.php';
require_once __DIR__ . '/../class/Users.php';


class User {

    public function getAllUsers() {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // La requête SQL pour récupérer tous les utilisateurs
        $sql = 'SELECT * FROM utilisateurs';
        $stat = $BD->pdo->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe\User');
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
        $stat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'Classe\User');
        $stat->execute();

        // Récupérer l'utilisateur sous forme d'objet
        $user = $stat->fetch();
        $BD->deconnexion();

        return $user;
    }

    // Récupérer un utilisateur par email
    public function getUserByEmail($email) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();
    
        // Requête SQL pour récupérer un utilisateur par email
        $sql = 'SELECT * FROM utilisateurs WHERE email = :email';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->setFetchMode(PDO::FETCH_CLASS | PDO::FETCH_PROPS_LATE, 'classe\User');
        $stat->execute();
    
        // Récupérer l'utilisateur sous forme d'objet
        $user = $stat->fetch();
        $BD->deconnexion();
    
        return $user;
    }

    // Ajouter un utilisateur (NOUVELLE MÉTHODE)
    public function ajouterUtilisateur($pseudo, $email, $password, $admin = 0) {
        $BD = new GestionBD();
        $BD->connexion();
        
        $sql = 'INSERT INTO utilisateurs (pseudo, email, password, admin) VALUES (:pseudo, :email, :password, :admin)';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $stat->bindParam(':email', $email, PDO::PARAM_STR);
        $stat->bindParam(':password', $password, PDO::PARAM_STR);
        $stat->bindParam(':admin', $admin, PDO::PARAM_INT);
        
        $result = $stat->execute();
        $BD->deconnexion();
        
        return $result;
    }

    // Modifier un utilisateur (NOUVELLE MÉTHODE COMPLÈTE)
    public function modifierUtilisateur($originalPseudo, $userData) {
        $BD = new GestionBD();
        $BD->connexion();
        
        try {
            // Ignorer toute tentative de modification du pseudo
            if (isset($userData['pseudo'])) {
                unset($userData['pseudo']);
            }
            
            // Si aucune donnée à mettre à jour, retourner true
            if (empty($userData)) {
                return true;
            }
            
            // Construire la requête SQL pour la mise à jour
            $sql = 'UPDATE utilisateurs SET ';
            $params = [];
            
            foreach ($userData as $key => $value) {
                $sql .= "$key = :$key, ";
                $params[":$key"] = $value;
            }
            
            // Supprimer la virgule finale et l'espace
            $sql = rtrim($sql, ', ');
            
            // Ajouter la condition WHERE
            $sql .= ' WHERE pseudo = :originalPseudo';
            $params[':originalPseudo'] = $originalPseudo;
            
            // Exécuter la requête pour l'utilisateur
            $stat = $BD->pdo->prepare($sql);
            $result = $stat->execute($params);
            
            $BD->deconnexion();
            return $result;
        } catch (Exception $e) {
            $BD->deconnexion();
            throw $e;
        }
    }

    // Modifier un utilisateur (email et mot de passe)
    public function updateUser($pseudo, $newEmail, $newPassword) {
        $BD = new GestionBD();
        $BD->connexion();
    
        // Utiliser "password" au lieu de "mot_de_passe"
        $sql = 'UPDATE utilisateurs SET email = :email, password = :password WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stat->bindParam(':password', $newPassword, PDO::PARAM_STR);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        
        $result = $stat->execute();
        $BD->deconnexion();
        
        return $result;
    }
    
    // Mettre à jour uniquement l'email d'un utilisateur
    public function updateUserEmail($pseudo, $newEmail) {
        $BD = new GestionBD();
        $BD->connexion();
    
        $sql = 'UPDATE utilisateurs SET email = :email WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':email', $newEmail, PDO::PARAM_STR);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        
        $result = $stat->execute();
        $BD->deconnexion();
        
        return $result;
    }

    // Supprimer un utilisateur (RENOMMER LA MÉTHODE)
    public function supprimerUtilisateur($pseudo) {
        return $this->deleteUser($pseudo);
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

    // Mettre à jour le statut admin (NOUVELLE MÉTHODE)
    public function toggleAdmin($pseudo, $adminStatus) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        // Requête SQL pour définir le statut admin
        $sql = 'UPDATE utilisateurs SET admin = :admin WHERE pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':admin', $adminStatus, PDO::PARAM_INT);
        $stat->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

        // Exécuter la requête
        $result = $stat->execute();
        $BD->deconnexion();

        return $result;
    }

    // Passer un utilisateur au rôle admin / non-admin (basculer)
    public function toggleAdminSwitch($pseudo) {
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