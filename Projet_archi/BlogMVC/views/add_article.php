<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/Article.php';

// Création d'une instance de la classe Article
$articleModel = new Article($connexion);

// Vérification si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $titre = $_POST['titre'] ?? '';
    $contenu = $_POST['contenu'] ?? '';
    $categorie_id = $_POST['categorie_id'] ?? '';

    // Appel à la méthode addArticle pour ajouter l'article dans la base de données
    $nouvelArticleId = $articleModel->addArticle($titre, $contenu, $categorie_id);

    // Redirection vers une page de confirmation ou autre
    header('Location: manage_articles.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Article</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }

        .article-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .article-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group textarea {
            width: 100%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group select{
            width: 30%;
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 150px;
            resize: vertical;
        }

        .form-group button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #0056b3;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="article-container">
        <h1>Ajouter un Article</h1>
        <a href="manage_articles.php" class="button">Retour à l'arrière</a>
        <form action="add_article.php" method="post">
            <div class="form-group">
                <label for="titre">Titre :</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu :</label>
                <textarea id="contenu" name="contenu" required></textarea>
            </div>
            <div class="form-group">
                <label for="categorie_id">Catégorie :</label>
                <select id="categorie_id" name="categorie_id" required>
                    <option value="">Sélectionner une catégorie</option>    
                    <option value="1">Sport</option>
                    <option value="2">Santé</option>
                    <option value="3">Éducation</option>
                    <option value="4">Politique</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="button">Ajouter l'article</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>
