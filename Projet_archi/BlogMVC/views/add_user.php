<?php
session_start();
// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/User.php';

// Gestion de l'ajout d'un nouvel utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Création d'une instance de User pour gérer l'ajout d'utilisateur
    $userModel = new User($connexion);
    $userModel->addUser($username, $password, $role);

    // Redirection après l'ajout
    header('Location: manage_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter Utilisateur</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .user-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .user-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], input[type="password"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        select {
            width: calc(100% - 22px); /* ajustement pour le padding du select */
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="user-container">
        <h1>Ajouter Utilisateur</h1>
        <a href="manage_users.php" class="button">Retour à l'arrière</a>

        <!-- Formulaire d'ajout d'utilisateur -->
        <form method="post">
            <label for="username">Nom d'utilisateur:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            <br>
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <label for="role">Rôle:</label>
            <select id="role" name="role">
                <option value="visiteur">Visiteur</option>
                <option value="éditeur">Éditeur</option>
                <option value="administrateur">Administrateur</option>
            </select>
            <br>
            <button type="submit">Ajouter Utilisateur</button>
        </form>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>
