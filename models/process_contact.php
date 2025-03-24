<?php
// filepath: c:\xampp\htdocs\WebsiteProg\models\process_contact.php

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
    
    // En-têtes
    $headers = "From: noreply@geodex.fr\r\n"; // Adresse neutre pour éviter les problèmes de spoofing
    $headers .= "Reply-To: " . $email . "\r\n";
    
    // Tenter d'envoyer le mail, mais aussi l'enregistrer dans un fichier
    $mail_sent = mail($to, $subject, $message_body, $headers);
    
    // Enregistrer le message dans un fichier log
    $log_dir = __DIR__ . '/../logs';
    if (!file_exists($log_dir)) {
        if (!mkdir($log_dir, 0755, true)) {
            // Si impossible de créer le dossier logs
            header("Location: ../control/contact.php?error=" . urlencode("Une erreur est survenue lors de l'enregistrement du message."));
            exit;
        }
    }
    
    $log_file = $log_dir . '/contact_messages.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "==========\nDate: $timestamp\nNom: $name\nEmail: $email\nMessage:\n$message\n==========\n\n";
    
    $saved = file_put_contents($log_file, $log_message, FILE_APPEND);
    
    // Si le mail est envoyé OU si le message est enregistré, rediriger vers la confirmation
    if ($mail_sent || $saved) {
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