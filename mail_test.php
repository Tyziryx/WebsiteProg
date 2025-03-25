<?php
// Test de configuration du serveur mail
echo "<h1>Test de configuration email</h1>";

// Afficher la configuration mail de PHP
echo "<h2>Configuration PHP mail</h2>";
echo "<pre>";
echo "sendmail_path: " . ini_get('sendmail_path') . "\n";
echo "SMTP: " . ini_get('SMTP') . "\n";
echo "smtp_port: " . ini_get('smtp_port') . "\n";
echo "mail.add_x_header: " . ini_get('mail.add_x_header') . "\n";
echo "</pre>";

// Test d'envoi vers une adresse pédagogique (interne à l'université)
$to_pedago = "alexi.miaille@pedago.univ-avignon.fr"; // Adresse pédagogique
$subject = "TEST INTERNE - Serveur universitaire - " . date('H:i:s');
$message = "Ceci est un test d'envoi de mail depuis le serveur de l'université.\n\n";
$message .= "Date et heure: " . date('Y-m-d H:i:s') . "\n\n";
$message .= "Ce test utilise une adresse de destination interne à l'université, ce qui devrait fonctionner.\n\n";
$message .= "Merci,\nFormulaire de contact Geodex";

// En-têtes optimisés
$sender_email = "uapv2401411@etud.univ-avignon.fr";
$headers = "From: $sender_email\r\n";
$headers .= "Reply-To: $sender_email\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

echo "<h2>Test d'envoi vers adresse pédagogique</h2>";
$result = mail($to_pedago, $subject, $message, $headers);
echo "Résultat de mail() vers adresse pédagogique: " . ($result ? "Succès (selon PHP)" : "Échec") . "<br/>";

// Générer un identifiant unique pour ce test
$test_id = date('Ymd_His') . '_' . substr(md5(rand()), 0, 6);
echo "<p>Identifiant unique de ce test: <strong>$test_id</strong></p>";
echo "<p>Si vous recevez l'email, vérifiez que cet identifiant y figure.</p>";

// Ajouter l'identifiant au message pour le rendre unique
$message_unique = $message . "\n\nIdentifiant de test: " . $test_id;

// Second test avec identifiant unique
echo "<h2>Second test avec ID unique</h2>";
$result_unique = mail($to_pedago, "TEST UNIQUE ID: $test_id", $message_unique, $headers);
echo "Résultat du second test: " . ($result_unique ? "Succès (selon PHP)" : "Échec");

// Gardons aussi un test vers Gmail pour référence
$to_gmail = "geodex.contact@gmail.com";
echo "<h2>Test comparatif vers Gmail</h2>";
$result_gmail = mail($to_gmail, "TEST GMAIL COMPARATIF: $test_id", $message_unique, $headers);
echo "Résultat du test vers Gmail: " . ($result_gmail ? "Succès (selon PHP)" : "Échec");
echo "<p>Ce test vers Gmail est inclus à titre de comparaison, mais a peu de chances de fonctionner.</p>";
?>