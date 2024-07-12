<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../controllers/ArticleController.php';
require_once __DIR__ . '/../models/Article.php';

// Création d'une instance de ArticleController en passant la connexion en paramètre
$articleController = new ArticleController($connexion);

// Récupération du rôle de l'utilisateur depuis le contrôleur d'articles
$role = $articleController->getRole();

// Vérification si l'utilisateur a le droit d'accéder à cette page (éditeur ou administrateur)
if (!in_array($role, ['éditeur', 'administrateur'])) {
    // Redirection vers une page d'erreur ou une autre page appropriée
    header('Location: index.php');
    exit;
}

// Récupération de tous les articles depuis la classe Article
$articleModel = new Article($connexion);
$articles = $articleModel->getAllArticles();

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../accueil.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Articles</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
                /* Styles globaux */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545; /* Rouge */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333; /* Rouge plus sombre au survol */
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gestion des Articles</h1>
            <form method="POST" style="display: inline;">
                <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
            </form>
        </div>
        <a href="../index.php" class="button">Retour à l'accueil</a>
        <a href="add_article.php" class="button">Ajouter un article</a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?php echo $article['id']; ?></td>
                        <td><?php echo $article['titre']; ?></td>
                        <td><?php echo $article['categorie_libelle']; ?></td>
                        <td>
                            <a class="button" href="edit_article.php?id=<?php echo $article['id']; ?>">Modifier</a>
                            <a class="button" href="delete_article.php?id=<?php echo $article['id']; ?>">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>