<?php
// Ajouter toutes les dépendances nécessaires
require_once __DIR__ . '/../config/GestionBD.php';
require_once __DIR__ . '/../config/Pierre.php';

// Démarrer la session si elle ne l'est pas déjà
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

echo "<h1>Diagnostic complet pour GeoDex - " . date('Y-m-d H:i:s') . "</h1>";

// 1. Informations de session
echo "<h2>1. Session actuelle</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>2. Cookies</h2>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";

// 3. Test de connexion à la base de données
echo "<h2>3. Test de connexion à la base de données</h2>";
try {
    $db = new \bd\GestionBD();
    $pdo = $db->connexion();
    echo "<p style='color:green'>✓ Connexion à la base de données réussie!</p>";
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Erreur de connexion à la base de données: " . $e->getMessage() . "</p>";
    exit;
}

// 4. Vérification de l'email actuel
$email = $_SESSION['email'] ?? "Non connecté";
echo "<h2>4. Vérification de l'utilisateur avec email: $email</h2>";

if (!isset($_SESSION['email'])) {
    echo "<p style='color:red'>✗ Vous n'êtes pas connecté. Impossible de continuer.</p>";
} else {
    // Vérification directe dans la table utilisateurs
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $_SESSION['email']);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<p style='color:green'>✓ Utilisateur trouvé dans la table utilisateurs:</p>";
        echo "<pre>";
        print_r($user);
        echo "</pre>";
        
        // Vérification spécifique du champ pseudo
        if (empty($user['pseudo'])) {
            echo "<p style='color:red'>✗ PROBLÈME DÉTECTÉ: Le champ 'pseudo' est vide!</p>";
        }
    } else {
        echo "<p style='color:red'>✗ Utilisateur NON TROUVÉ dans la table utilisateurs avec email: {$_SESSION['email']}</p>";
        
        // Afficher tous les utilisateurs pour vérification
        $stmt = $pdo->query("SELECT email, pseudo FROM utilisateurs LIMIT 10");
        $allUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<p>Premiers utilisateurs dans la base de données:</p>";
        echo "<pre>";
        print_r($allUsers);
        echo "</pre>";
    }
    
    // 5. Test spécifique de la fonction problématique
    echo "<h2>5. Test de la fonction getUserPseudoFromEmail()</h2>";
    $pierreModel = new \bd\Pierre();
    $userPseudo = $pierreModel->getUserPseudoFromEmail($_SESSION['email']);
    
    if ($userPseudo) {
        echo "<p style='color:green'>✓ getUserPseudoFromEmail() a retourné: $userPseudo</p>";
    } else {
        echo "<p style='color:red'>✗ getUserPseudoFromEmail() n'a pas trouvé de pseudo!</p>";
        
        // Solution proposée
        echo "<h3>Solution proposée:</h3>";
        echo "<form method='post'>";
        echo "<input type='hidden' name='action' value='fix_user'>";
        echo "<label>Pseudo à associer à {$_SESSION['email']}: <input type='text' name='pseudo' value='Geodex'></label><br>";
        echo "<input type='submit' value='Ajouter/Mettre à jour l'utilisateur'>";
        echo "</form>";
    }
    
    // 6. Si le formulaire est soumis, créer ou mettre à jour l'utilisateur
    if (isset($_POST['action']) && $_POST['action'] === 'fix_user') {
        $pseudo = $_POST['pseudo'];
        
        try {
            // Vérifier si l'utilisateur existe déjà
            if ($user) {
                // Mise à jour du pseudo
                $stmt = $pdo->prepare("UPDATE utilisateurs SET pseudo = :pseudo WHERE email = :email");
            } else {
                // Création de l'utilisateur
                $stmt = $pdo->prepare("INSERT INTO utilisateurs (email, pseudo) VALUES (:email, :pseudo)");
            }
            
            $stmt->bindParam(':email', $_SESSION['email']);
            $stmt->bindParam(':pseudo', $pseudo);
            $stmt->execute();
            
            echo "<p style='color:green'>✓ Utilisateur mis à jour avec succès! Rafraîchissez la page pour voir les changements.</p>";
        } catch (Exception $e) {
            echo "<p style='color:red'>✗ Erreur lors de la mise à jour: " . $e->getMessage() . "</p>";
        }
    }
    
    // 7. Vérification des pierres de l'utilisateur
    echo "<h2>7. Pierres de l'utilisateur</h2>";
    if ($userPseudo) {
        $userStones = $pierreModel->getUserStones($userPseudo);
        echo "<p>Nombre de pierres découvertes: " . count($userStones) . "</p>";
        
        if (!empty($userStones)) {
            echo "<ul>";
            foreach ($userStones as $stone) {
                echo "<li>{$stone->nom_pierre} ({$stone->rarete})</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>Aucune pierre découverte.</p>";
        }
    } else {
        echo "<p>Impossible de vérifier les pierres sans pseudo.</p>";
    }
}

// Liens utiles
echo "<hr>";
echo "<p><a href='./'>Retour à l'accueil</a> | <a href='./geodex'>Accès à Geodex</a> | <a href='./dashboard'>Dashboard</a></p>";
?>