<?php
// models/Categorie.php

class Categorie {
    private $connexion;

    public function __construct($connexion) {
        $this->connexion = $connexion;
    }

    public function getAllCategories() {
        $requete = "SELECT * FROM Categorie";
        $resultat = $this->connexion->query($requete); // Utilisation de PDO pour exécuter la requête
        return $resultat->fetchAll(PDO::FETCH_ASSOC); // Récupération des résultats en utilisant PDO
    }
}
?>
