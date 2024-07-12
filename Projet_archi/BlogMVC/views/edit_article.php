<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../controllers/ArticleController.php';
require_once __DIR__ . '/../models/Article.php';

// Vérification si un identifiant d'article est spécifié
if (!isset($_GET['id']) || empty($_GET['id'])) {
    // Redirection vers une page d'erreur ou une autre page appropriée si l'id n'est pas fourni
    header('Location: index.php');
    exit;
}

// Création d'une instance de ArticleController en passant la connexion en paramètre
$articleController = new ArticleController($connexion);

// Récupération de l'article à éditer
$articleId = $_GET['id'];
$articleModel = new Article($connexion);
$article = $articleModel->getArticleById($articleId);

// Vérification si l'article existe
if (!$article) {
    // Redirection si l'article n'existe pas ou erreur de récupération
    header('Location: index.php');
    exit;
}

// Traitement du formulaire de mise à jour d'article
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $articleId = $_POST['article_id'];
    $titre = $_POST['titre'];
    $contenu = $_POST['contenu'];

    // Appel à la méthode pour mettre à jour l'article
    $success = $articleModel->updateArticle($articleId, $titre, $contenu);

    if ($success) {
        // Redirection vers une page de succès ou une autre page appropriée après la mise à jour
        header('Location: manage_articles.php');
        exit;
    } else {
        // Gestion de l'erreur ou redirection vers une page d'erreur
        echo "Erreur lors de la mise à jour de l'article.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Édition d'article</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Styles CSS pour le formulaire d'édition d'article */
        .article-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 200px;
        }

        .form-group button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group button:hover {
            background-color: #0056b3;
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
    <?php include __DIR__ . '/../views/header.php'; ?>
    <div class="article-container">
        <h1>Édition de l'article : <?php echo htmlspecialchars($article['titre']); ?></h1>
        <a href="manage_articles.php" class="button">Retour à l'arrière</a>
        <form action="" method="POST">
            <input type="hidden" name="article_id" value="<?php echo $article['id']; ?>">
            <div class="form-group">
                <label for="titre">Titre de l'article :</label>
                <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
            </div>
            <div class="form-group">
                <label for="contenu">Contenu de l'article :</label>
                <textarea id="contenu" name="contenu" required><?php echo htmlspecialchars($article['contenu']); ?></textarea>
            </div>
            <div class="form-group">
                <button type="submit">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>
