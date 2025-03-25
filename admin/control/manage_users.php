<?php 
session_start();
/*
if (!isset($_SESSION['user_id'])) {
    header("Location: ./control/login.php");
    exit;
}
*/
$racine_path = '../';

if (isset($_GET['id'])) {
    include $racine_path . 'templates/description.php';
} else {
    include $racine_path . 'templates/head.php';
    include $racine_path . 'templates/sidebar.php';

    // Titre de la page
    echo "<title>Gestion des Utilisateurs</title>";

    // Afficher la notification si elle existe
    if (isset($_GET['status']) && isset($_GET['message'])) {
        $status = $_GET['status'] === 'success' ? 'success' : 'error';
        $message = htmlspecialchars($_GET['message']);
        echo "<div class='notification notification-$status'>$message</div>";
        
        // Ajouter un script pour faire disparaître la notification après 5 secondes
        echo "<script>
            setTimeout(function() {
                const notification = document.querySelector('.notification');
                if (notification) {
                    notification.style.display = 'none';
                }
            }, 5000);
        </script>";
    }

    // Inclure le template pour les utilisateurs
    require_once __DIR__ . '/../templates/users.php';

}
?>
