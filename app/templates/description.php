<?php 
require_once __DIR__ . '/../../config/Pierre.php';
$pierreModel = new \bd\Pierre();
$nom_pierre = isset($_GET['id']) ? $_GET['id'] : '';

if (!$nom_pierre) {
    echo '<div class="error-message">Nom de pierre invalide.</div>';
    exit;
}

$stone = $pierreModel->getPierreByNom($nom_pierre);


if (!$stone) {
    echo '<div class="error-message">Pierre introuvable.</div>';
    exit;
}

?>

<?php include $racine_path .'templates/head.php'; ?>
<?php include $racine_path .'templates/sidebar.php'; ?>

<div class="image-container">
    <h1 class="image-title"><?php echo htmlspecialchars($stone->nom_pierre); ?></h1>
    
    <div class="image-content">
        <div class="image-box">
        <img src="../../images/<?php echo htmlspecialchars($stone->image); ?>" alt="<?php echo htmlspecialchars($stone->nom_pierre); ?>">
        </div>
        <p class="image-description">Rareté : <?php echo htmlspecialchars($stone->rarete); ?></p>
        <p class="image-description">Description : <?php echo nl2br(htmlspecialchars($stone->description)); ?></p>
    </div>

    <a href="geodex.php" class="back-link">Retour</a>
</div>
