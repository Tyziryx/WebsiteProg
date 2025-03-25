<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geodex</title>
    <meta name="description" content="Brève description de votre site pour les moteurs de recherche.">
    <meta name="author" content="Votre Nom">
    <link rel="icon" type="image/png" href="<?php echo $racine_path.'../public/images/favicon.png';?>">
    <link rel="stylesheet" href="<?php echo $racine_path.'templates/css/styles.css';?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <?php if (isset($_GET['page']) && $_GET['page'] === 'edit_profil'): ?>
    <!-- CSS spécifique pour la page de profil -->
    <link rel="stylesheet" href="<?php echo $racine_path.'templates/css/profil.css';?>">
    <?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Felipa&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
