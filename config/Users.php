<?php
namespace bd;

use PDO;
use bd\GestionBD;
require_once __DIR__ . '/GestionBD.php';
require_once __DIR__ . '/../class/Users.php';

/**
 * Classe User
 * 
 * Cette classe permet de gérer les utilisateurs dans la base de données. Elle inclut des méthodes pour récupérer, ajouter, modifier, supprimer des utilisateurs,
 * ainsi que pour gérer leur statut admin.
 */
class User {

    /**
     * Récupère tous les utilisateurs de la base de données.
     *
     * @return array Liste des utilisateurs sous forme d'objets.
     */
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

    /**
     * Récupère un utilisateur à partir de son pseudo.
     *
     * @param string $pseudo Le pseudo de l'utilisateur à rechercher.
     * @return mixed Un objet utilisateur ou false si non trouvé.
     */
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

/**
     * Récupère un utilisateur à partir de son adresse email.
     *
     * @param string $email L'adresse email de l'utilisateur à rechercher.
     * @return mixed Un objet utilisateur ou false si non trouvé.
     */
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

    /**
     * Ajoute un nouvel utilisateur dans la base de données.
     *
     * @param string  $pseudo   Le pseudo de l'utilisateur.
     * @param string  $email    L'adresse email de l'utilisateur.
     * @param string  $password Le mot de passe hashé de l'utilisateur.
     * @param integer $admin    Statut admin (0 ou 1). Par défaut : 0.
     * @return bool True si l'insertion a réussi, False sinon.
     */
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

    /**
     * Modifie les données d'un utilisateur (hors pseudo).
     *
     * @param string $originalPseudo Le pseudo d'origine de l'utilisateur.
     * @param array  $userData       Les nouvelles données à modifier (clé => valeur).
     * @return bool True si la mise à jour a réussi, False sinon.
     * @throws \Exception En cas d'erreur d'exécution SQL.
     */    public function modifierUtilisateur($originalPseudo, $userData) {
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

    /**
     * Met à jour l'email et le mot de passe d'un utilisateur.
     *
     * @param string $pseudo      Le pseudo de l'utilisateur.
     * @param string $newEmail    Le nouvel email.
     * @param string $newPassword Le nouveau mot de passe hashé.
     * @return bool True si la mise à jour a réussi, False sinon.
     */
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
    
    /**
     * Met à jour uniquement l'email d'un utilisateur.
     *
     * @param string $pseudo   Le pseudo de l'utilisateur.
     * @param string $newEmail Le nouvel email.
     * @return bool True si la mise à jour a réussi, False sinon.
     */    
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

    /**
     * Supprime un utilisateur (alias de deleteUser).
     *
     * @param string $pseudo Le pseudo de l'utilisateur à supprimer.
     * @return bool True si la suppression a réussi, False sinon.
     */    
    public function supprimerUtilisateur($pseudo) {
        return $this->deleteUser($pseudo);
    }

    /**
     * Supprime un utilisateur de la base de données.
     *
     * @param string $pseudo Le pseudo de l'utilisateur à supprimer.
     * @return bool True si la suppression a réussi, False sinon.
     */    
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

    /**
     * Met à jour le statut admin d'un utilisateur.
     *
     * @param string  $pseudo      Le pseudo de l'utilisateur.
     * @param integer $adminStatus 1 pour admin, 0 pour utilisateur simple.
     * @return bool True si la mise à jour a réussi, False sinon.
     */    
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

    /**
     * Bascule le statut admin d'un utilisateur (admin ↔ non-admin).
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @return bool True si la mise à jour a réussi, False sinon.
     */    
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

    /**
     * Vérifie si un utilisateur est administrateur.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @return mixed 1 si admin, 0 si non, false si l'utilisateur n'existe pas.
     */    
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