<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/User.php';

session_start();

if (isset($_GET['id'])) {
    $userModel = new User($connexion);
    $userId = $_GET['id'];
    
    // Mettre le token à null
    $userModel->updateToken($userId, null);

    header('Location: manage_users.php');
    exit;
}
?>
