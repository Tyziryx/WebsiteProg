<?php
// Namespace des classes de la base de donnée
namespace bd;

// Pour pouvoir utiliser le namespace de PDO qui se trouve à la racine
use bd\GestionBD;
use \PDO;

// Pour que PDO est la class Animal
require('../class/Pierre.php');

// pour pouvoir créer la connexion à la BD
require('GestionBD.php');
use bd\GestionBD;

// classe Animal comme définit sur le diagramme de classe
class Pierre{

    public function listePierre(){

        // Connexion àla bd
        $BD = new GestionBD();
        $BD->connexion();

        //Prépartion de la requête
        //$sql = 'SELECT * from site."Pierre";';
        $sql = 'SELECT * from pierre;';
        $stat = $BD->pdo->prepare($sql);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Pierre');
        $stat->execute();
        $pierres = $stat->fetchAll();
        $BD->deconnexion();

        return $pierres;
    }

    public function getPierre($id){
        // Connexion àla bd
        $BD = new GestionBD();
        $BD->connexion();

        //$sql = 'SELECT * from site."Animal" where id=:id;';
        $sql = 'SELECT * from pierre where id=:id;';
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam('id', $id);
        $stat->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, 'classe\Animal');
        $stat->execute();
        $pierre = $stat->fetch();
        $BD->deconnexion();

        // si l'animal n'existe pas en base de donnée je renvoie une page 404,
        // le mieux serait d'avoir une page propre à votre site, du style Oups la page n'existe plus...
        // Et une redirection vers l'accueil
        if(!$pierre){
            header('HTTP/1.0 404 Not Found');
            exit;
        }

        return $pierre;
    }

    public function updateAnimal($pierre){
        // a faire

    }

    public function saveAnimal($pierre){
        // a faire

    }

}



?>