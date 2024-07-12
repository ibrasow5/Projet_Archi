<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/User.php';

// Vérification de l'existence de l'id de l'utilisateur à supprimer
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage_users.php'); // Redirection si l'id n'est pas fourni
    exit;
}

// Création d'une instance de User en passant la connexion en paramètre
$userModel = new User($connexion);

// Suppression de l'utilisateur
$userModel->deleteUser($_GET['id']);

// Redirection vers la page de gestion des utilisateurs après suppression
header('Location: manage_users.php');
exit;
?>
