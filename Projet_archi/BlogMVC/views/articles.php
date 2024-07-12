<?php
// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../controllers/ArticleController.php';

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    // Démarrer la session si elle n'est pas déjà démarrée
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Détruire la session
    session_destroy();
    // Rediriger vers la page d'accueil
    header('Location: accueil.php');
    exit;
}

// Définir le nombre d'articles par page
$articlesPerPage = 10;

// Obtenir le numéro de la page actuelle
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $articlesPerPage;

// Obtenir les articles pour la page actuelle
$articles = array_slice($articles, $start, $articlesPerPage);

// Calculer le nombre total de pages
$totalArticles = count($articles); // Le total devrait venir du contrôleur
$totalPages = ceil($totalArticles / $articlesPerPage);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Actualités Polytechniciennes</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-right: 10px;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .article-box {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .article-box h2 {
            margin-bottom: 5px;
        }

        .article-box p {
            margin-top: 5px;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545; /* Rouge */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333; /* Rouge plus sombre au survol */
        }

        .button-container {
            overflow: auto;
            margin-bottom: 20px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            color: #007bff;
            padding: 10px 20px;
            text-decoration: none;
            border: 1px solid #007bff;
            border-radius: 5px;
            margin: 0 5px;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination .active {
            background-color: #007bff;
            color: #fff;
            border: 1px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="article-container">
        <div class="button-container">
            <?php if ($showManageButton): ?>
                <div style="display: inline-block;">
                    <a href="views/manage_articles.php" class="button">Gérer les articles</a>                
                </div>
            <?php endif; ?>

            <?php if ($showManageUsersButton): ?>
                <div style="display: inline-block;">
                    <a href="views/manage_users.php" class="button">Gérer les utilisateurs</a>
                </div>
            <?php endif; ?>
            
            <div style="float: right;">
                <form method="POST" style="display: inline;">
                    <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
                </form>
            </div>
        </div>

        <?php if (isset($articles) && count($articles) > 0): ?>
            <?php foreach ($articles as $article): ?>
                <div class="article-box">
                    <h2><a href="?id=<?php echo $article['id']; ?>"><?php echo $article['titre']; ?></a></h2>
                    <p><?php echo substr($article['contenu'], 0, 100); ?>...</p>
                </div>
            <?php endforeach; ?>

            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="?page=<?php echo $page - 1; ?>">&laquo; Précédent</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $page) ? 'active' : ''; ?>"><?php echo $i; ?></a>
                <?php endfor; ?>

                <?php if ($page < $totalPages): ?>
                    <a href="?page=<?php echo $page + 1; ?>">Suivant &raquo;</a>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Aucun article trouvé.</p>
        <?php endif; ?>      
    </div>
    <?php include __DIR__ . '/footer.php'; ?>
</body>
</html>
