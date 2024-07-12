<?php
// Inclusion du fichier de configuration pour la connexion à la base de données
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../controllers/UserController.php';

// Création d'une instance de UserController en passant la connexion en paramètre
$userController = new UserController($connexion);

// Récupération de tous les utilisateurs 
$userModel = new User($connexion);
$users = $userModel->getAllUsers();

// Gérer la déconnexion
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: ../accueil.php');
    exit;
}

// Gérer la suppression du token
if (isset($_POST['delete_token'])) {
    $userId = $_POST['user_id'];
    $userModel->deleteToken($userId);
    header('Location: manage_users.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
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
            max-width: 800px;
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

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        td {
            vertical-align: top;
        }

        .user-actions a {
            display: inline-block;
            padding: 5px 10px;
            margin-right: 5px;
            text-decoration: none;
            color: #007bff;
        }

        .user-actions a:hover {
            background-color: #f0f0f0;
        }

        .logout-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545; /* Rouge */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        .logout-button:hover {
            background-color: #c82333; /* Rouge plus sombre au survol */
        }
    </style>
</head>
<body>
    <div class="user-container">
        <div class="header">
            <h1>Gestion des Utilisateurs</h1>
            <form method="POST" style="display: inline;">
                <button type="submit" name="logout" class="logout-button">Se déconnecter</button>
            </form>
        </div>
        <a href="../index.php" class="button">Retour à l'accueil</a>
        <a href="add_user.php" class="button">Ajouter un utilisateur</a>

        <!-- Tableau pour afficher les utilisateurs -->
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Rôle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['username']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td>
                            <a class="button" href="edit_user.php?id=<?php echo $user['id']; ?>">Modifier</a>
                            <a class="button" href="delete_user.php?id=<?php echo $user['id']; ?>">Supprimer</a>
                            <?php if (!empty($user['token'])): ?>
                                <form method="POST">
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <button class="button" type="submit" name="delete_token">Supprimer Token</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include __DIR__ . '/../views/footer.php'; ?>
</body>
</html>
