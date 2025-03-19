<?php 
$id = isset($_GET['id']) ? intval($_GET['id']) : 1; // Récupération sécurisée de l'ID

// Données factices (à remplacer par une base de données)
$images = [
    1 => ["name" => "Image 1", "description" => "Description de l'image 1"],
    2 => ["name" => "Image 2", "description" => "Description de l'image 2"],
    3 => ["name" => "Image 3", "description" => "Description de l'image 3"],
];

$imageInfo = $images[$id % 3 + 1] ?? ["name" => "Image inconnue", "description" => "Aucune information disponible."];

?>

<?php include $racine_path .'templates/head.php'; ?>
<?php include $racine_path .'templates/sidebar.php'; ?>

<div class="image-container">
    <h1 class="image-title"><?php echo $imageInfo['name']; ?></h1>
    
    <div class="image-content">
        <div class="image-box">
            <img src="../images/image<?php echo $id % 3+1; ?>.png" alt="<?php echo $imageInfo['name']; ?>">
        </div>
        <p class="image-description"><?php echo $imageInfo['description']; ?></p>
    </div>

    <a href="geodex.php" class="back-link">Retour</a>
</div>

