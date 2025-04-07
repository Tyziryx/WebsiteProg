<?php
// Namespace des classes de la base de donnée
namespace bd;

// Pour pouvoir utiliser le namespace de PDO qui se trouve à la racine
use bd\GestionBD;
use \PDO;

// Pour que PDO est la class Pierre
require_once __DIR__ . '/../class/Pierre.php';

// pour pouvoir créer la connexion à la BD
require_once __DIR__ . '/GestionBD.php';

/**
 * Classe Pierre
 *
 * Gère les opérations liées aux pierres dans la base de données.
 * Permet d'ajouter, supprimer, récupérer des pierres et gérer les informations associées.
 */
class Pierre {
    
    /**
     * Récupère toutes les pierres de la table `pierre`.
     *
     * @return array Tableau d'objets Pierre provenant de la base de données.
     */
    public function listePierre() {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        //Préparation de la requête
        $sql = 'SELECT * from pierre;';
        $stat = $BD->pdo->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierres = $stat->fetchAll();
        $BD->deconnexion();

        return $pierres;
    }
    /**
     * Récupère une pierre spécifique en fonction de son identifiant.
     *
     * @param int $id L'identifiant de la pierre à récupérer.
     * @return mixed Un objet Pierre si trouvé, sinon false.
     */
    public function getPierre($id) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'SELECT * from pierre where id=:id;';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam('id', $id);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierre = $stat->fetch();
        $BD->deconnexion();
        
        return $pierre;
    }

    /**
     * Récupère les informations d'une pierre par son nom à partir de la table `geodex`.
     *
     * @param string $nom_pierre Le nom de la pierre à chercher.
     * @return \classe\Pierre|null L'objet Pierre si trouvé, sinon null.
     */
    public function getPierreByNom($nom_pierre) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();
    
        // Vérifie si les données existent dans la table correcte
        $sql = 'SELECT nom_pierre, description, rarete, image FROM geodex WHERE nom_pierre = :nom_pierre;';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':nom_pierre', $nom_pierre, PDO::PARAM_STR);
        $stat->setFetchMode(PDO::FETCH_ASSOC);  // Changer FETCH_CLASS en FETCH_ASSOC pour tester
        $stat->execute();
        $pierreData = $stat->fetch();
    
        $BD->deconnexion();
    
        if (!$pierreData) {
            return null;
        }
    
        // Instancier un objet Pierre en remplissant ses propriétés
        return new \classe\Pierre(
            $pierreData['nom_pierre'],
            $pierreData['description'],
            $pierreData['image'],
            $pierreData['rarete']
        );
    }
    
    
    
    /**
     * Récupère les pierres correspondant à une rareté donnée.
     *
     * @param string $rarete La rareté des pierres à récupérer (ex : "commune", "rare", etc.).
     * @return array Tableau d'objets Pierre correspondant à la rareté.
     */
    public function getPierresByRarete($rarete) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'SELECT * from geodex where rarete=:rarete;';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam('rarete', $rarete);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierres = $stat->fetchAll();
        $BD->deconnexion();
        
        return $pierres;
    }

    /**
     * Retourne le nom de la pierre (cette méthode doit être utilisée sur un objet Pierre)
     * 
     * @return string Le nom de la pierre
     */
    public function getNom() {
        // Retourne simplement la propriété nom_pierre de cette instance
        return $this->nom_pierre;
    }




    /**
     * Récupère les FAQs où admin est false
     * 
     * @return array Tableau associatif des questions et réponses
     */
    public function getFAQs() {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT question, reponse FROM faq WHERE admin = false";
        $stat = $BD->pdo->prepare($sql);
        $stat->execute();
        $faqs = $stat->fetchAll(PDO::FETCH_ASSOC);
        $BD->deconnexion();
        
        return $faqs;
    }

        /**
     * Ajoute une FAQ à la base de données.
     *
     * @param string $question La question à ajouter
     * @param string $reponse La réponse associée
     * @param bool $admin Indique si la FAQ est réservée aux admins (par défaut : false)
     * @return bool Retourne true si l'ajout a réussi, sinon false
     */
    public function ajouterFaq($question, $reponse, $admin = false) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "INSERT INTO faq (question, reponse, admin) VALUES (:question, :reponse, :admin)";
        $stat = $BD->pdo->prepare($sql);
        $result = $stat->execute([
            ':question' => $question,
            ':reponse' => $reponse,
            ':admin' => $admin ? 1 : 0  // Conversion en booléen SQL
        ]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Supprime une FAQ de la base de données en fonction de la question.
     *
     * @param string $question La question à supprimer
     * @return bool Retourne true si la suppression a réussi, sinon false
     */
    public function supprimerFaq($question) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();
    
        // Préparer la requête
        $sql = "DELETE FROM faq WHERE question = :question";
        $stat = $BD->pdo->prepare($sql);
    
        // Lier la question à la requête
        $stat->bindValue(':question', $question, PDO::PARAM_STR);
    
        // Exécuter la requête
        $stat->execute();
    
        // Vérifier si une ligne a été supprimée
        if ($stat->rowCount() > 0) {
            $BD->deconnexion();
            return true; // FAQ supprimée avec succès
        } else {
            $BD->deconnexion();
            return false; // Aucune FAQ supprimée, peut-être que la question n'existe pas
        }
    }
    
    /**
     * Récupère les questions-réponses de la FAQ réservées aux administrateurs (admin = true).
     *
     * @return array Tableau associatif des FAQs admin sous forme [question => reponse].
     */
    public function getFAQsAdmin() {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT question, reponse FROM faq WHERE admin = true";
        $stat = $BD->pdo->prepare($sql);
        $stat->execute();
        $faqs = $stat->fetchAll(PDO::FETCH_ASSOC);
        $BD->deconnexion();
        
        return $faqs;
    }

    /**
     * Vérifie si un utilisateur possède une pierre spécifique.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $nom_pierre Le nom de la pierre.
     * @return bool True si l'utilisateur possède la pierre, sinon false.
     */
    public function userHasStone($pseudo, $nom_pierre) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        // Utiliser les noms de colonnes corrects: pseudo et nom_pierre
        $sql = 'SELECT COUNT(*) FROM pierre WHERE pseudo = :pseudo AND nom_pierre = :nom_pierre';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo);
        $stat->bindParam(':nom_pierre', $nom_pierre);
        $stat->execute();
        
        $count = $stat->fetchColumn();
        $BD->deconnexion();
        
        return $count > 0;
    }

    /**
     * Ajoute une pierre au profil d'un utilisateur.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @param string $nom_pierre Le nom de la pierre à ajouter.
     * @return bool True si l'ajout a réussi, false sinon.
     */
    public function addStoneToUser($pseudo, $nom_pierre) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        // Utiliser les noms de colonnes corrects: pseudo et nom_pierre
        // Retirer la colonne obtenu qui n'existe plus
        $sql = 'INSERT INTO pierre (pseudo, nom_pierre) VALUES (:pseudo, :nom_pierre)';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo);
        $stat->bindParam(':nom_pierre', $nom_pierre);
        
        $result = $stat->execute();
        $BD->deconnexion();
        
        return $result;
    }

    /**
     * Récupère le pseudo d'un utilisateur à partir de son adresse email.
     *
     * @param string $email L'adresse email de l'utilisateur.
     * @return string|false Le pseudo de l'utilisateur si trouvé, sinon false.
     */
    public function getUserPseudoFromEmail($email) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'SELECT pseudo FROM utilisateurs WHERE email = :email';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':email', $email);
        $stat->execute();
        
        $pseudo = $stat->fetchColumn();
        $BD->deconnexion();
        
        return $pseudo;
    }




    /**
     * Récupère toutes les pierres disponibles dans le geodex.
     *
     * @return array Tableau d'objets Pierre triés par nom.
     */
    public function getAllPierres() {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'SELECT * FROM geodex ORDER BY nom_pierre';
        $stat = $BD->pdo->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierres = $stat->fetchAll();
        $BD->deconnexion();
        
        return $pierres;
    }

    /**
     * Récupère les pierres découvertes par un utilisateur.
     *
     * @param string $pseudo Le pseudo de l'utilisateur.
     * @return array Tableau d'objets Pierre découverts par l'utilisateur.
     */
    public function getUserStones($pseudo) {
        // Connexion à la bd
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'SELECT g.* FROM geodex g 
                JOIN pierre p ON g.nom_pierre = p.nom_pierre 
                WHERE p.pseudo = :pseudo';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':pseudo', $pseudo);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierres = $stat->fetchAll();
        $BD->deconnexion();
        
        return $pierres;
    }


    /**
     * Ajoute une pierre avec un nom, une description et une rareté.
     * 
     * @param string $nom Nom de la pierre
     * @param string $description Description de la pierre
     * @param string $rarete Rareté de la pierre
     * @return bool Retourne true si l'ajout a réussi, false sinon
     */
    public function ajouterPierreAvecRarete($nom, $description, $rarete) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();

        $sql = 'INSERT INTO geodex (nom_pierre, description, rarete) VALUES (:nom, :description, :rarete)';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':nom', $nom, PDO::PARAM_STR);
        $stat->bindParam(':description', $description, PDO::PARAM_STR);
        $stat->bindParam(':rarete', $rarete, PDO::PARAM_STR);

        $result = $stat->execute();
        $BD->deconnexion();

        return $result;
    }

    /**
     * Supprime une pierre du geodex par son nom.
     *
     * @param string $nom_pierre Le nom de la pierre à supprimer.
     * @return bool True si la suppression a réussi, false sinon.
     */
    public function supprimerPierre($nom_pierre) {
        // Connexion à la base de données
        $BD = new GestionBD();
        $BD->connexion();
    
        // Requête SQL pour supprimer la pierre
        $sql = 'DELETE FROM geodex WHERE nom_pierre = :nom_pierre';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':nom_pierre', $nom_pierre, PDO::PARAM_STR);
    
        // Exécution de la requête
        $result = $stat->execute();
    
        // Déconnexion de la base de données
        $BD->deconnexion();
    
        // Retourne le résultat de l'exécution de la requête
        return $result;
    }
}
?>