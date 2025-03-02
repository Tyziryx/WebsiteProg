<?php
$titre = 'Accueil'; 
$racine_path = './';
?>

<?php include($racine_path.'control/home.php');?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>