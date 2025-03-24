<?php
// filepath: c:\xampp\htdocs\WebsiteProg\check_phpmailer.php

echo "<h1>Vérification de PHPMailer</h1>";

// Méthode 1: Vérifier si l'autoload de Composer est présent
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "<p style='color: green;'>✓ L'autoloader de Composer est présent.</p>";
    
    // Essayer de charger l'autoloader
    try {
        require_once __DIR__ . '/vendor/autoload.php';
        echo "<p style='color: green;'>✓ L'autoloader de Composer a été chargé avec succès.</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Erreur lors du chargement de l'autoloader: " . $e->getMessage() . "</p>";
    }
    
    // Vérifier si les classes PHPMailer sont disponibles
    if (class_exists('PHPMailer\PHPMailer\PHPMailer')) {
        echo "<p style='color: green;'>✓ La classe PHPMailer est disponible.</p>";
    } else {
        echo "<p style='color: red;'>✗ La classe PHPMailer n'est pas disponible.</p>";
    }
} else {
    echo "<p style='color: red;'>✗ L'autoloader de Composer n'est pas présent.</p>";
}

// Méthode 2: Vérifier si PHPMailer est directement dans le répertoire
$phpmailer_paths = [
    __DIR__ . '/PHPMailer/',
    __DIR__ . '/vendor/phpmailer/phpmailer/src/',
    __DIR__ . '/lib/PHPMailer/'
];

foreach ($phpmailer_paths as $path) {
    if (file_exists($path . 'PHPMailer.php')) {
        echo "<p style='color: green;'>✓ PHPMailer trouvé dans: $path</p>";
    }
}

echo "<h2>Instructions d'installation si PHPMailer n'est pas présent:</h2>";
echo "<p>Pour installer PHPMailer via Composer:</p>";
echo "<pre>
composer require phpmailer/phpmailer
</pre>";

echo "<p>OU télécharger manuellement depuis GitHub:</p>";
echo "<pre>
1. Télécharger depuis: https://github.com/PHPMailer/PHPMailer/archive/master.zip
2. Extraire le fichier ZIP
3. Copier le dossier 'src' dans votre projet et le renommer en 'PHPMailer'
</pre>";

// Aide au débogage courant
echo "<h2>Informations serveur:</h2>";
echo "<p>Version PHP: " . phpversion() . "</p>";
echo "<p>Extensions chargées: </p>";
echo "<pre>";
$extensions = get_loaded_extensions();
sort($extensions);
echo implode(", ", $extensions);
echo "</pre>";

// Vérifier les fonctions mail pertinentes
echo "<h2>Fonctions mail:</h2>";
if (function_exists('mail')) {
    echo "<p style='color: green;'>✓ La fonction mail() est disponible.</p>";
} else {
    echo "<p style='color: red;'>✗ La fonction mail() n'est pas disponible.</p>";
}

if (extension_loaded('openssl')) {
    echo "<p style='color: green;'>✓ L'extension OpenSSL est chargée (nécessaire pour SMTP sécurisé).</p>";
} else {
    echo "<p style='color: red;'>✗ L'extension OpenSSL n'est pas chargée.</p>";
}
?>