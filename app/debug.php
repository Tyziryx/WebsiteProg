<?php
// Démarrer la session
session_start();

// Afficher toutes les informations de débogage
echo "<h1>Informations de Débogage</h1>";
echo "<h2>Variables de Session</h2>";
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";

echo "<h2>Cookies</h2>";
echo "<pre>";
var_dump($_COOKIE);
echo "</pre>";

echo "<h2>Chemins d'Inclusion</h2>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

// Boutons d'action
echo "<h2>Actions</h2>";
?>

<form method="post">
    <button type="submit" name="reset_cookies">Supprimer les cookies</button>
</form>

<form method="post">
    <button type="submit" name="set_session">Définir la session</button>
</form>

<br>
<a href="index.php">Retour à l'accueil</a>
<a href="dashboard">Aller au dashboard</a>

<?php
// Gérer les actions
if (isset($_POST['reset_cookies'])) {
    setcookie('session_user', '', time() - 3600, '/');
    setcookie('session_date', '', time() - 3600, '/');
    echo "<p>Cookies supprimés!</p>";
}

if (isset($_POST['set_session'])) {
    $_SESSION['email'] = 'bypass@example.com';
    echo "<p>Session définie!</p>";
}
?>