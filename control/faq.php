<?php
$racine_path = '../';




if(isset($_POST['accept_cookies'])) {
    // Définir le cookie pour 30 jours
    setcookie('cookie_consent', 'accepted', time() + (86400 * 30), "/");
    
    // Rediriger pour éviter la résoumission du formulaire
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<?php include('templates/head.php'); ?>
<?php include('templates/header.php'); ?>
<?php include('templates/cookies.php'); ?>
<?php include('templates/faq.php'); ?>
<?php include('templates/footer.php'); ?>
