<?php
session_start();
error_log("=== GEODEX DEBUG ===");

// Affichez toutes les informations de session et cookies
echo "<h1>Diagnostic GeoDex</h1>";

echo "<h2>Session:</h2>";
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

echo "<h2>Cookies:</h2>";
echo "<pre>";
print_r($_COOKIE);
echo "</pre>";

// Si aucune session active, tentez de restaurer depuis les cookies
if (!isset($_SESSION['email']) && isset($_COOKIE['session_user'])) {
    $_SESSION['email'] = $_COOKIE['session_user'];
    echo "<p style='color:green'>Session restaurée depuis cookie: " . $_COOKIE['session_user'] . "</p>";
}

// Créez un lien direct avec contournement
echo "<p><a href='control/geodex.php?bypass=1'>Accès direct à GeoDex avec bypass</a></p>";
?>