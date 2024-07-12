<?php
session_start();

// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/User.php';

// Vérification de l'existence de l'id de l'utilisateur à modifier
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: manage_users.php'); // Redirection si l'id n'est pas fourni
    exit;
}

// Création d'une instance de User en passant la connexion en paramètre
$userModel = new User($connexion);

// Récupération des détails de l'utilisateur à modifier
$user = $userModel->getUserById($_GET['id']);

// Vérification si l'utilisateur existe
if (!$user) {
    header('Location: manage_users.php'); // Redirection si l'utilisateur n'existe pas
    exit;
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Validation éventuelle des données ici

    // Mise à jour des informations de l'utilisateur
    $userModel->updateUser($_GET['id'], $username, $role);

    // Redirection vers la page de gestion des utilisateurs après modification
    header('Location: manage_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Utilisateur</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
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
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .user-container h1 {
            margin-bottom: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"], select {
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
        <h1>Modifier Utilisateur</h1>
        <a href="manage_users.php" class="button">Retour</a>

        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
            <br>
            <label for="role">Rôle:</label>
            <select id="role" name="role">
                <option value="visiteur" <?php if ($user['role'] === 'visiteur') echo 'selected'; ?>>Visiteur</option>
                <option value="éditeur" <?php if ($user['role'] === 'éditeur') echo 'selected'; ?>>Éditeur</option>
                <option value="administrateur" <?php if ($user['role'] === 'administrateur') echo 'selected'; ?>>Administrateur</option>
            </select>
            <br>
            <button type="submit">Enregistrer les modifications</button>
        </form>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>
