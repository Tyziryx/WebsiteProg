<?php
// Vérification si le cookie existe déjà
if(!isset($_COOKIE['cookie_consent'])) {
    $show_cookie_banner = true;
} else {
    $show_cookie_banner = false;
}

// Traitement de l'acceptation des cookies
if(isset($_POST['accept_cookies'])) {
    // Définir le cookie pour 30 jours
    setcookie('cookie_consent', 'accepted', time() + (86400 * 30), "/");
    
    // Rediriger pour éviter la résoumission du formulaire
    header("Location: " . $_SERVER['REQUEST_URI']);
    exit;
}
?>

<?php if(isset($show_cookie_banner) && $show_cookie_banner): ?>
<div id="cookie-banner" class="cookie-banner">
    <div class="cookie-content">
        <p>Ce site utilise des cookies pour améliorer votre expérience. En continuant, vous acceptez notre politique de cookies.</p>
        <div class="cookie-buttons">
            <form method="post">
                <button type="submit" name="accept_cookies" class="cookie-accept">Accepter</button>
                <a href="control/faq.php" class="cookie-more">En savoir plus</a>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>