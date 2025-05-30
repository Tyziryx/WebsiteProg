<?php
// filepath: /home/nas-wks01/users/uapv2401411/Donnees_itinerantes_depuis_serveur_pedagogique/public_html/config/notifications.php

/**
 * Définit un message de notification qui sera affiché lors de la prochaine requête.
 * 
 * @param string $status Type de notification ('success', 'error', 'warning', 'info')
 * @param string $message Contenu du message à afficher
 * @return void
 */
function setNotification($status, $message) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $_SESSION['notification'] = [
        'status' => $status,
        'message' => $message,
        'timestamp' => time() // Ajouter un timestamp pour gérer l'expiration
    ];
}

/**
 * Récupère et supprime la notification stockée en session.
 * 
 * @return array|null Tableau contenant le statut et le message, ou null si aucune notification
 */
function getNotification() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (isset($_SESSION['notification'])) {
        // Vérifier si la notification n'est pas trop ancienne (30 secondes max)
        if ($_SESSION['notification']['timestamp'] > time() - 30) {
            $notification = $_SESSION['notification'];
            unset($_SESSION['notification']);
            return $notification;
        }
        // Supprimer les notifications trop anciennes
        unset($_SESSION['notification']);
    }
    
    return null;
}

/**
 * Affiche la notification si elle existe, avec le bon formatage HTML.
 * 
 * @return void
 */
function displayNotification() {
    $notification = getNotification();
    
    if ($notification) {
        $status = htmlspecialchars($notification['status']);
        $message = htmlspecialchars($notification['message']);
        
        echo "<div class='notification {$status}' id='notification-msg'>{$message}</div>";
        
        // Script pour faire disparaître la notification - exécution immédiate
        echo "<script>
        (function() {
            // S'exécute immédiatement après le chargement
            document.addEventListener('DOMContentLoaded', function() {
                const notification = document.getElementById('notification-msg');
                if (notification) {
                    setTimeout(function() {
                        notification.classList.add('fade-out');
                        setTimeout(function() {
                            notification.style.display = 'none';
                            notification.remove(); // Suppression complète du DOM
                        }, 500);
                    }, 5000);
                }
            });
        })();
        </script>";
    }
}
?>