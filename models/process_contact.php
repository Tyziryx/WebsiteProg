<?php
// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    // Validation simple des données
    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "Tous les champs sont requis.";
        header("Location: /AMS/control/contact.php");
        exit;
    }

    // ajouter vraiment l'email ici
    // mail($email_dest, "Message reçu", $message, $headers);

    // Si l'envoi réussit ou la validation est réussie
    $_SESSION['success'] = "Merci pour votre message. Nous vous répondrons rapidement.";
    header("Location: /AMS/control/confirmation.php");
    exit;
} else {
    // Rediriger vers la page de contact si l'accès au process est direct
    header("Location: /AMS/control/contact.php");
    exit;
}
?>
