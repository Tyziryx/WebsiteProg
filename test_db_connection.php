<?php
// Inclusion du fichier de configuration et de GestionBD
require_once 'config/config.php';
require_once 'config/GestionBD.php';

echo "<h1>Test de connexion à la base de données PostgreSQL</h1>";

// Affichage des informations (sans le mot de passe)
echo "<h2>Paramètres de connexion</h2>";
echo "<ul>";
echo "<li>Hôte : " . DB_HOST . "</li>";
echo "<li>Port : " . DB_PORT . "</li>";
echo "<li>Base de données : " . DB_NAME . "</li>";
echo "<li>Utilisateur : " . DB_USER . "</li>";
echo "<li>Schéma : " . DB_SCHEMA . "</li>";
echo "</ul>";

// Tentative de connexion avec PDO directement
echo "<h2>Test 1: Connexion directe avec PDO</h2>";
try {
    $dsn = "pgsql:host=".DB_HOST.";port=".DB_PORT.";dbname=".DB_NAME;
    $pdo = new PDO($dsn, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<div style='color: green; font-weight: bold;'>✓ Connexion PDO réussie!</div>";
    
    // Test du schéma
    $pdo->exec("SET search_path TO ".DB_SCHEMA);
    echo "<div style='color: green;'>✓ Schéma ".DB_SCHEMA." défini</div>";
    
    // Vérifier la version PostgreSQL
    $query = $pdo->query("SELECT version()");
    $version = $query->fetch(PDO::FETCH_ASSOC);
    echo "<div>Version PostgreSQL : " . $version['version'] . "</div>";
    
    // Test de requête sur une table
    echo "<h3>Tables disponibles dans le schéma ".DB_SCHEMA.":</h3>";
    try {
        $tables = $pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = '".DB_SCHEMA."'");
        echo "<ul>";
        while($table = $tables->fetch(PDO::FETCH_ASSOC)) {
            echo "<li>" . $table['table_name'] . "</li>";
        }
        echo "</ul>";
    } catch (PDOException $e) {
        echo "<div style='color: orange;'>⚠️ Impossible de lister les tables : " . $e->getMessage() . "</div>";
    }
} catch (PDOException $e) {
    echo "<div style='color: red; font-weight: bold;'>✗ Erreur de connexion PDO : " . $e->getMessage() . "</div>";
}

// Test avec la classe GestionBD
echo "<h2>Test 2: Connexion via GestionBD</h2>";
try {
    $db = new \bd\GestionBD();
    $pdo = $db->connexion();
    
    if ($pdo) {
        echo "<div style='color: green; font-weight: bold;'>✓ Connexion GestionBD réussie!</div>";
        
        // Test simple pour vérifier si on peut exécuter une requête
        $query = $pdo->query("SELECT count(*) FROM information_schema.tables WHERE table_schema = '".DB_SCHEMA."'");
        $count = $query->fetchColumn();
        echo "<div>Nombre de tables dans le schéma ".DB_SCHEMA." : " . $count . "</div>";
    } else {
        echo "<div style='color: red; font-weight: bold;'>✗ Échec de connexion via GestionBD</div>";
    }
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>✗ Erreur GestionBD : " . $e->getMessage() . "</div>";
}
?>