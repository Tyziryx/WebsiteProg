<?php
echo "<h2>Vérification des extensions PHP</h2>";

if (extension_loaded('pdo_pgsql')) {
    echo "<p style='color: green;'>✓ L'extension PDO PostgreSQL est chargée.</p>";
} else {
    echo "<p style='color: red;'>✗ L'extension PDO PostgreSQL N'EST PAS chargée.</p>";
}

if (extension_loaded('pgsql')) {
    echo "<p style='color: green;'>✓ L'extension PostgreSQL est chargée.</p>";
} else {
    echo "<p style='color: red;'>✗ L'extension PostgreSQL N'EST PAS chargée.</p>";
}

echo "<h3>Liste de toutes les extensions chargées :</h3>";
echo "<pre>";
print_r(get_loaded_extensions());
echo "</pre>";
?>