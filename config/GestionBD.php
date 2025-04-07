<?php
// Namespace des classes de la base de donnée
namespace bd;
require_once('config.php');

/**
 * Classe GestionBD
 * 
 * Gère la connexion et la déconnexion à la base de données PostgreSQL.
 * Utilise les constantes définies dans le fichier `config.php` pour établir la connexion.
 */
class GestionBD{
    /**
     * Instance PDO représentant la connexion à la base de données
     *
     * @var \PDO|null
     */
    public $pdo;

    /**
     * Établit une connexion à la base de données PostgreSQL
     * en utilisant les paramètres définis dans `config.php`.
     * 
     * @return \PDO|null Retourne l'objet PDO si la connexion est réussie, sinon null en cas d'erreur
     */
    public function connexion(){
        // recuperer le fichier conf et faire une connexion
        try{
            $this->pdo = new \PDO("pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME, DB_USER, DB_PASSWORD);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        }catch(\PDOException $e){
            echo 'Exception PDO : '.$e->getMessage();
            return null;
        }
    }

    /**
     * Ferme la connexion à la base de données
     * 
     * @return void
     */
    public function deconnexion(){
        // faire la deconnexion
        $this->pdo = null;
    }
}
?>