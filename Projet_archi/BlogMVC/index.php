<?php
session_start();


require_once 'config/connexion.php';
require_once 'controllers/ArticleController.php';
require_once 'controllers/CategorieController.php';

// Afficher les catégories
$categorieController = new CategorieController($connexion);
$categories = $categorieController->index();

// Afficher tous les articles ou un article spécifique
$articleController = new ArticleController($connexion);
if (isset($_GET['id'])) {
    $articleController->show($_GET['id']);
} else {
    $articleController->index();
}
?>
