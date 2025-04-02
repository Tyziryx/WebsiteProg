<?php


if(isset($_POST['accept_cookies'])) {
    // Définir le cookie pour 30 jours
    setcookie('cookie_consent', 'accepted', time() + (86400 * 30), "/");
    
    // Rediriger pour éviter la résoumission du formulaire
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<?php include($racine_path.'templates/head.php'); ?>
<?php include($racine_path.'templates/header.php'); ?>
<?php include($racine_path.'templates/cookies.php'); ?>
<?php include($racine_path.'templates/main.php'); ?>
<?php include($racine_path.'templates/footer.php'); ?>
