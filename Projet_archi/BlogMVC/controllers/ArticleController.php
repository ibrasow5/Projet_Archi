<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/Article.php';

class ArticleController {
    private $articleModel;
    private $role;

    public function __construct($connexion) {
        $this->articleModel = new Article($connexion);

        // Récupérez le rôle de l'utilisateur depuis la session
        $this->role = isset($_SESSION['user']['role']) ? $_SESSION['user']['role'] : '';
    }

    public function show($id) {
        $article = $this->articleModel->getArticleById($id);
        include __DIR__ . '/../views/article.php';
    }

    public function index() {
        if (isset($_GET['categorie'])) {
            $articles = $this->articleModel->getArticlesByCategory($_GET['categorie']);
        } else {
            $articles = $this->articleModel->getAllArticles();
        }

        // Déterminez si les boutons doivent être affichés
        $showManageButton = in_array($this->role, ['éditeur', 'administrateur']);

        $showManageUsersButton = in_array($this->role, ['administrateur']);

        include __DIR__ . '/../views/articles.php';
    }

    // Ajoutez cette méthode pour récupérer le rôle de l'utilisateur
    public function getRole() {
        return $this->role;
    }
}
?>
