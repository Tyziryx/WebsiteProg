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
}
?>