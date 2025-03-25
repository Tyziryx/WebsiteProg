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
    echo "<title>Gestion des Pierres</title>";

    // Afficher la notification si elle existe
    if (isset($_GET['status']) && isset($_GET['message'])) {
        $status = $_GET['status'] === 'success' ? 'success' : 'error';
        $message = htmlspecialchars($_GET['message']);
        echo "<div class='notification {$status}' id='notification'>{$message}</div>";
        
        // Ajouter un script pour faire disparaître la notification après 5 secondes
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const notification = document.getElementById('notification');
                if (notification) {
                    setTimeout(function() {
                        notification.classList.add('fade-out');
                        setTimeout(function() {
                            notification.style.display = 'none';
                        }, 500);
                    }, 5000);
                }
            });
        </script>";
    }

    // Inclure le template pour les pierres
    require_once __DIR__ . '/../templates/geodex.php';

}
?>
