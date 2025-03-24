<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validation simple des données
    if (empty($name) || empty($email) || empty($message)) {
        $error_message = "Tous les champs sont requis.";
        header("Location: /AMS/control/contact.php?error=" . urlencode($error_message));
        exit;
    }

    // Adresse e-mail du destinataire
    $email_dest = "geodex.contact@gmail.com";

    // Sujet de l'email
    $subject = "Nouveau message de contact de $name";

    // Corps du message
    $email_body = "Nom: $name\n";
    $email_body .= "Email: $email\n\n";
    $email_body .= "Message:\n$message\n";

    // En-têtes de l'e-mail
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Envoyer l'e-mail
    if (mail($email_dest, $subject, $email_body, $headers)) {
        header("Location: /AMS/control/confirmation.php");
        exit;
    } else {
        header("Location: /AMS/control/contact.php?error=" . urlencode("Erreur lors de l'envoi du message. Veuillez réessayer plus tard."));
        exit;
    }
} else {
    // Rediriger vers la page de contact si l'accès au process est direct
    header("Location: /AMS/control/contact.php");
    exit;
}
?>
