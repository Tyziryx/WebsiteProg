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

// classe Pierre comme définit sur le diagramme de classe
class Pierre {

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
     * Récupère les pierres par rareté
     * 
     * @param string $rarete La rareté des pierres à récupérer
     * @return array Tableau d'objets Pierre
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




    /*
    * Récupère toutes les pierres disponibles 
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

    /*
    * Récupère les pierres découvertes par un utilisateur
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