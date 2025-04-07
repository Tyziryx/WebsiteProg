<?php
require_once __DIR__ . '/../config/notifications.php';
session_start();

/**
 * Fonction pour enregistrer un message dans un fichier journal.
 *
 * @param string $name    Le nom de l'émetteur.
 * @param string $email   L'adresse email de l'émetteur.
 * @param string $message Le contenu du message.
 * @param string $status  Le statut de l'envoi ('success' ou 'error').
 * @return boolean True si l'enregistrement a réussi, False sinon.
 */
function logMessage($name, $email, $message, $status = 'success') {
    $log_dir = __DIR__ . '/../logs';
    if (!file_exists($log_dir)) {
        if (!mkdir($log_dir, 0755, true)) {
            return false;
        }
    }
    
    $log_file = $log_dir . '/contact_messages.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "==========\nDate: $timestamp\nStatut: $status\nNom: $name\nEmail: $email\nMessage:\n$message\n==========\n\n";
    
    return file_put_contents($log_file, $log_message, FILE_APPEND) !== false;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validation simple des données
    if (empty($name) || empty($email) || empty($message)) {
        setNotification('error', "Tous les champs sont requis.");
        header("Location: ../contact");
        exit;
    }
    
    // Vérification de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        setNotification('error', "Format d'email invalide.");
        header("Location: ../contact");
        exit;
    }

    // Destinataire - adresse alumni qui fonctionne
    $to = 'alexi.miaille@alumni.univ-avignon.fr';
    
    // Identifiant unique pour ce message
    $message_id = date('YmdHis') . '_' . substr(md5($email . time()), 0, 6);
    
    // Sujet avec indication pour transfert vers Gmail
    $subject = 'Message Geodex pour transfert vers Gmail - ' . $name . ' - ' . $message_id;
    
    // Corps du message sans la note pour transfert
    $message_body = "Nom: " . $name . "\n";
    $message_body .= "Email: " . $email . "\n\n";
    $message_body .= $message . "\n";
    
    // En-têtes pour l'email
    $headers = 'From: ' . $email . "\r\n" .
               'Reply-To: ' . $email . "\r\n" .
               'X-Mailer: PHP/' . phpversion();
    
    // Envoyer l'email
    $mail_result = mail($to, $subject, $message_body, $headers);
    
    // Enregistrer le message dans un fichier journal
    logMessage($name, $email, $message, $mail_result ? 'success' : 'error');

    // Sauvegarder une copie du message dans un dossier messages
    $message_dir = __DIR__ . '/../messages';
    if (!is_dir($message_dir) && !mkdir($message_dir, 0755, true)) {
        // Continuer même si le dossier ne peut pas être créé
    } else {
        $message_file = $message_dir . '/msg_' . $message_id . '.txt';
        file_put_contents($message_file, 
            "ID: $message_id\nTo: $to\nFrom: $email\nName: $name\nSubject: $subject\n\n$message_body"
        );
    }

    if($mail_result) {
        // Rediriger avec un message de succès
        setNotification('success', "Votre message a été envoyé avec succès. Nous vous contacterons bientôt.");
        header("Location: ../confirmation");
        exit;
    } else {
        // En cas d'erreur, rediriger avec un message d'erreur
        setNotification('error', "Une erreur est survenue lors de l'envoi du message. Veuillez réessayer.");
        header("Location: ../contact");
        exit;
    }
} else {
    // Rediriger vers la page de contact si l'accès au script est direct
    header("Location: ../contact");
    exit;
}
?>