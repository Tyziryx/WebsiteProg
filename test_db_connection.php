<?php
// Inclusion du fichier de configuration
require_once 'config/config.php';

// Affichage des informations (sans le mot de passe)
echo "<h2>Tentative de connexion à la base de données</h2>";
echo "Hôte : " . DB_HOST . "<br>";
echo "Port : " . DB_PORT . "<br>";
echo "Nom de la BDD : " . DB_NAME . "<br>";
echo "Utilisateur : " . DB_USER . "<br>";

// Tentative de connexion
try {
    $dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME.";";
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    
    // Configuration pour afficher les erreurs PostgreSQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color: green; font-weight: bold; margin-top: 20px;'>
          Connexion à la base de données réussie !
          </div>";
    
    // Test simple pour vérifier si on peut interroger la base
    $query = $pdo->query("SELECT version()");
    $version = $query->fetch(PDO::FETCH_ASSOC);
    
    echo "<p>Version de PostgreSQL : " . $version['version'] . "</p>";
    
} catch (PDOException $e) {
    echo "<div style='color: red; font-weight: bold; margin-top: 20px;'>
          ERREUR DE CONNEXION : " . $e->getMessage() . "
          </div>";
    echo "<p>Vérifiez vos paramètres de connexion et assurez-vous que le serveur PostgreSQL est accessible.</p>";
}
?>