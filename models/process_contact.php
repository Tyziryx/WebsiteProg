<?php
// filepath: c:\xampp\htdocs\WebsiteProg\models\process_contact.php

// Fonction pour journaliser les messages
function logMessage($status, $name, $email, $message) {
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
        $error_message = "Tous les champs sont requis.";
        header("Location: ../control/contact.php?error=" . urlencode($error_message));
        exit;
    }
    
    // Vérification de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format d'email invalide.";
        header("Location: ../control/contact.php?error=" . urlencode($error_message));
        exit;
    }

    // Destinataire
    $to = 'geodex.contact@gmail.com';
    
    // Sujet
    $subject = 'Nouveau message de contact de ' . $name;
    
    // Corps du message
    $message_body = "Nom: " . $name . "\n";
    $message_body .= "Email: " . $email . "\n\n";
    $message_body .= "Message:\n" . $message;
    
    // En-têtes modifiés pour améliorer la délivrabilité
    $headers = "From: noreply@geodex.fr\r\n"; // Adresse d'envoi neutre
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Tentative d'envoi du mail
    $mail_result = mail($to, $subject, $message_body, $headers);
    
    // Journaliser le message (que l'envoi ait réussi ou échoué)
    $status = $mail_result ? "Email envoyé (selon PHP)" : "Échec d'envoi";
    logMessage($status, $name, $email, $message);

    if($mail_result) {
        // Rediriger avec un message de succès
        header("Location: ../control/confirmation.php?success=" . urlencode("Votre message a été envoyé avec succès. Nous vous contacterons bientôt."));
        exit;
    } else {
        // En cas d'erreur, rediriger avec un message d'erreur
        header("Location: ../control/contact.php?error=" . urlencode("Une erreur est survenue lors de l'envoi du message. Veuillez réessayer."));
        exit;
    }
} else {
    // Rediriger vers la page de contact si l'accès au script est direct
    header("Location: ../control/contact.php");
    exit;
}
?>