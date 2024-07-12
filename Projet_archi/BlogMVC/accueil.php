<?php
session_start();
require_once __DIR__ . '/views/header.php';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue sur notre blog</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        /* Styles spécifiques pour la page d'accueil */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            position: relative; /* Définition de la position relative pour le body */
        }

        .wrapper {
            min-height: 100%; /* Minimum de la hauteur de l'écran */
            position: relative; /* Position relative pour le contenu */
            overflow: auto; /* Défilement si le contenu est plus grand */
            padding-bottom: 60px; /* Hauteur du footer */
        }

        .content {
            padding: 20px; /* Espacement autour du contenu */
        }

        .footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            position: absolute; /* Position absolue par rapport au bas de l'écran */
            bottom: 0; /* Collé au bas de l'écran */
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            text-align: center;
        }

        .container h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        .container p {
            font-size: 1.2em;
            margin-bottom: 30px;
        }

        .actions {
            margin-top: 20px;
        }

        .actions .btn {
            display: inline-block;
            padding: 12px 24px;
            margin-right: 10px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .actions .btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="content">
            <div class="container">
                <h2>Bienvenue sur notre blog</h2>
                <p>Connectez-vous ou inscrivez-vous pour accéder à nos articles.</p>
                <div class="actions">
                    <a href="views/login.php" class="btn">Se connecter</a>
                    <a href="views/register.php" class="btn">S'inscrire</a>
                </div>
            </div>
        </div>

        <div class="footer">
            <?php require_once __DIR__ . '/views/footer.php'; ?>
        </div>
    </div>
</body>
</html>
