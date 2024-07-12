<!-- views/login.php -->

<?php
session_start();
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../config/connexion.php'; // Connexion à la base de données
require_once __DIR__ . '/../models/User.php'; // Modèle User pour gérer les utilisateurs
require_once __DIR__ . '/../controllers/AuthController.php'; // Contrôleur d'authentification

// Initialisation du contrôleur d'authentification avec le modèle User
$userModel = new User($connexion); // Assume que $connexion est défini dans connexion.php
$authController = new AuthController($userModel);

// Traitement de la soumission du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Appel de la méthode de connexion dans AuthController
    $authController->login($username, $password);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Blog d'Ibrahima</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <style>
        body {
            background-color: #f0f0f0;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input[type="text"],
        .form-group input[type="password"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Connexion</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Nom d'utilisateur</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Se connecter</button>
            </div>
        </form>

        <p>Vous n'avez pas de compte ? <a href="register.php">S'inscrire ici</a></p>
    </div>

    <?php require_once __DIR__ . '/../views/footer.php'; ?>
</body>
</html>