<?php
class Article {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getArticleById($id) {
        $requete = "SELECT * FROM Article WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllArticles() {
        $requete = "SELECT a.*, c.libelle AS categorie_libelle 
                    FROM Article a 
                    JOIN Categorie c ON a.categorie = c.id";
        $statement = $this->connexion->query($requete);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticlesByCategory($categoryId) {
        $requete = "SELECT * FROM Article WHERE categorie = :categoryId";
        $statement = $this->connexion->prepare($requete);
        $statement->execute(['categoryId' => $categoryId]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateArticle($id, $titre, $contenu) {
        $requete = "UPDATE Article SET titre = :titre, contenu = :contenu WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        $statement->execute([
            'id' => $id,
            'titre' => $titre,
            'contenu' => $contenu
        ]);
        // Retourne true si la mise à jour a réussi
        return $statement->rowCount() > 0;
    }

    public function addArticle($titre, $contenu, $categorie) {
        $requete = "INSERT INTO Article (titre, contenu, categorie) VALUES (:titre, :contenu, :categorie)";
        $statement = $this->connexion->prepare($requete);
        $statement->execute([
            'titre' => $titre,
            'contenu' => $contenu,
            'categorie' => $categorie
        ]);
        // Retourne l'ID de l'article nouvellement inséré
        return $this->connexion->lastInsertId();
    }

    public function deleteArticleById($id) {
        $requete = "DELETE FROM Article WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        $statement->execute(['id' => $id]);
        // Optionnel : Vérification du succès de la suppression
        return $statement->rowCount() > 0; // Retourne true si au moins une ligne a été affectée
    }
}

?>
