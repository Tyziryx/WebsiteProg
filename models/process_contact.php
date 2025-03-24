<?php
// Inclure l'autoloader de Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Importer les classes PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

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

    // Créer une nouvelle instance de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur
        $mail->isSMTP();                                      // Utiliser SMTP
        $mail->Host       = 'smtp.gmail.com';                 // Serveur SMTP Gmail
        $mail->SMTPAuth   = true;                             // Activer l'authentification SMTP
        $mail->Username   = 'geodex.contact@gmail.com';       // Votre adresse email SMTP
        $mail->Password   = 'votre_mot_de_passe_app';         // Mot de passe d'application (pas votre mot de passe Gmail)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   // Activer le chiffrement TLS
        $mail->Port       = 587;                              // Port TCP pour se connecter

        // Destinataires
        $mail->setFrom($email, $name);
        $mail->addAddress('geodex.contact@gmail.com', 'Geodex Contact');  // Adresse de destination
        $mail->addReplyTo($email, $name);

        // Contenu
        $mail->isHTML(true);                                  // Format HTML
        $mail->Subject = "Nouveau message de contact de $name";
        
        // Corps du message en HTML
        $mail->Body    = "
            <h2>Nouveau message de contact</h2>
            <p><strong>Nom:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Message:</strong></p>
            <p>" . nl2br(htmlspecialchars($message)) . "</p>
        ";
        
        // Version texte alternative
        $mail->AltBody = "Nom: $name\nEmail: $email\n\nMessage:\n$message";

        $mail->send();
        // Rediriger avec un message de succès
        header("Location: ../control/confirmation.php?success=" . urlencode("Votre message a été envoyé avec succès. Nous vous contacterons bientôt."));
        exit;
    } catch (Exception $e) {
        // En cas d'erreur, rediriger avec un message d'erreur
        header("Location: ../control/contact.php?error=" . urlencode("Erreur lors de l'envoi du message: " . $mail->ErrorInfo));
        exit;
    }
} else {
    // Rediriger vers la page de contact si l'accès au process est direct
    header("Location: ../control/contact.php");
    exit;
}
?>