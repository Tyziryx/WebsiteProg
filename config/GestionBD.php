<?php
// Namespace des classes de la base de donnée
namespace bd;
require_once('config.php');

// classe GestionBD comme demandée
class GestionBD{
    public $pdo;

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

    public function deconnexion(){
        // faire la deconnexion
        $this->pdo = null;
    }
}
?>