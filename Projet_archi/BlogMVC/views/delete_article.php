<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/Article.php';

// Vérification de l'existence du paramètre id dans l'URL
if (isset($_GET['id'])) {
    $articleModel = new Article($connexion);
    $articleId = $_GET['id'];

    // Suppression de l'article
    $deleted = $articleModel->deleteArticleById($articleId);

    if ($deleted) {
        // Redirection vers la page de gestion des articles avec un message de succès
        header('Location: manage_articles.php?deleted=true');
        exit;
    } else {
        // Redirection vers la page de gestion des articles avec un message d'erreur
        header('Location: manage_articles.php?deleted=false');
        exit;
    }
} else {
    // Redirection vers une autre page ou gestion d'erreur appropriée si l'id n'est pas fourni
    header('Location: manage_articles.php');
    exit;
}
?>
