<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/Categorie.php';

class CategorieController {
    private $categorieModel;

    public function __construct($connexion) {
        $this->categorieModel = new Categorie($connexion);
    }

    public function index() {
        $categories = $this->categorieModel->getAllCategories();
        include __DIR__ . '/../views/header.php'; 
        include __DIR__ . '/../views/menu.php';
        return $categories;
    }
}
?>
