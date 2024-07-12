<?php
require_once __DIR__ . '/../config/connexion.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $mot_de_passe = $_POST['password']; // Renommé pour correspondre au formulaire

            // Validation des identifiants de connexion
            $user = $this->userModel->findByUsername($username);

            if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
                
                // Génération d'un nouveau token
                $token = bin2hex(random_bytes(32));

                // Mettre à jour le token dans la base de données
                $this->userModel->updateToken($user['id'], $token);

                session_start();
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'],
                    'token' => $token // Stockage du token dans la session
                ];

                // Redirection en fonction du rôle de l'utilisateur
                $this->redirectToRolePage($user['role']);
            } else {
                echo "Nom d'utilisateur ou mot de passe incorrect.";
            }
        }

        // Affichage de la vue de connexion
        include __DIR__ . '/../views/login.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $mot_de_passe = $_POST['password'];

            // Création d'un nouvel utilisateur
            if ($this->userModel->create($username, $mot_de_passe)) {
                header('Location: ../views/login.php');
                exit;
            } else {
                echo "Erreur lors de l'inscription. Veuillez réessayer.";
            }
        }

        // Affichage de la vue d'inscription
        include __DIR__ . '/../views/register.php';
    }

    private function redirectToRolePage($role) {
        switch ($role) {
            case 'administrateur':
                header('Location: ../index.php?action=admin_dashboard');
                break;
            case 'éditeur':
                header('Location: ../index.php?action=editor_dashboard');
                break;
            case 'visiteur':
            default:
                header('Location: ../index.php');
                break;
        }
        exit;
    }
}
?>
