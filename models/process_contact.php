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
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    
    // Tentative d'envoi du mail
    if(mail($to, $subject, $message_body, $headers)) {
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