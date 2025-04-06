<?php 
session_start();

if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    header('Location: ../index.php?error=Erreur de sécurité. Veuillez réessayer.');
    exit();
}
?>
<?php
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
        header("Location: ../contact?error=" . urlencode($error_message));
        exit;
    }
    
    // Vérification de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Format d'email invalide.";
        header("Location: ../contact?error=" . urlencode($error_message));
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
    $message_body .= "Message:\n" . $message;
    
    // En-têtes optimisés
    $sender_email = "uapv2401411@etud.univ-avignon.fr";
    
    $headers = "From: $sender_email\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Tentative d'envoi du mail
    $mail_result = mail($to, $subject, $message_body, $headers);
    
    // Débogage avancé
    $debug_info = "Mail function returned: " . ($mail_result ? "true" : "false") . "\n";
    $debug_info .= "PHP version: " . phpversion() . "\n";
    $debug_info .= "Sendmail path: " . ini_get('sendmail_path') . "\n";
    $debug_info .= "SMTP setting: " . ini_get('SMTP') . "\n";
    $debug_info .= "smtp_port: " . ini_get('smtp_port') . "\n";
    $debug_info .= "Headers:\n" . $headers . "\n";
    $debug_info .= "To: " . $to . "\n";
    $debug_info .= "Subject: " . $subject . "\n";
    $debug_info .= "Message ID: " . $message_id . "\n";
    
    // Journaliser le message avec infos de débogage
    $status = $mail_result ? "Email envoyé (selon PHP)" : "Échec d'envoi";
    logMessage($status . "\n" . $debug_info, $name, $email, $message);

    // Créer une copie du message dans un fichier séparé pour chaque tentative
    $message_dir = __DIR__ . '/../messages';
    if (!file_exists($message_dir) && !mkdir($message_dir, 0755, true)) {
        // Continuer même si le dossier ne peut pas être créé
    } else {
        $message_file = $message_dir . '/msg_' . $message_id . '.txt';
        file_put_contents($message_file, 
            "ID: $message_id\nTo: $to\nFrom: $email\nName: $name\nSubject: $subject\n\n$message_body"
        );
    }

    if($mail_result) {
        // Rediriger avec un message de succès
        header("Location: ../confirmation?success=" . urlencode("Votre message a été envoyé avec succès. Nous vous contacterons bientôt."));
        exit;
    } else {
        // En cas d'erreur, rediriger avec un message d'erreur
        header("Location: ../contact?error=" . urlencode("Une erreur est survenue lors de l'envoi du message. Veuillez réessayer."));
        exit;
    }
} else {
    // Rediriger vers la page de contact si l'accès au script est direct
    header("Location: ../contact");
    exit;
}
?>