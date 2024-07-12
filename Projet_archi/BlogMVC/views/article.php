<?php
// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../controllers/ArticleController.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités Polytechniciennes</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .article-title {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .article-content {
            font-size: 16px;
            line-height: 1.6;
            color: #666;
        }

        .error-message {
            color: #ff0000;
            font-weight: bold;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($article): ?>
            <div class="article-opened">
                <h2 class="article-title"><?php echo htmlspecialchars($article['titre']); ?></h2>
                <p class="article-content"><?php echo nl2br(htmlspecialchars($article['contenu'])); ?></p>
                <a href="index.php" class="button">Retour aux articles</a>
            </div>
        <?php else: ?>
            <p class="error-message">Article non trouvé.</p>
        <?php endif; ?>
    </div>
    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>