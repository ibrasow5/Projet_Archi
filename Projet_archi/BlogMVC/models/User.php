<?php
require_once __DIR__ . '/../config/connexion.php';

class User {
    private $connexion;

    public function __construct(PDO $connexion) {
        $this->connexion = $connexion;
    }

    public function create($username, $mot_de_passe) {
        try {
            $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            $query = "INSERT INTO utilisateurs (username, mot_de_passe) VALUES (:username, :mot_de_passe)";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':mot_de_passe', $hashed_password);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de l'inscription : " . $e->getMessage();
            return false;
        }
    }

    public function findByUsername($username) {
        try {
            $query = "SELECT * FROM utilisateurs WHERE username = :username";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la recherche de l'utilisateur : " . $e->getMessage();
            return null;
        }
    }

    public function getAllUsers() {
        $requete = "SELECT * FROM utilisateurs";
        $statement = $this->connexion->query($requete);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $requete = "SELECT * FROM utilisateurs WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $username, $role) {
        $requete = "UPDATE utilisateurs SET username = :username, role = :role WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        return $statement->execute(['id' => $id, 'username' => $username, 'role' => $role]);
    }

    public function deleteUser($id) {
        $requete = "DELETE FROM utilisateurs WHERE id = :id";
        $statement = $this->connexion->prepare($requete);
        return $statement->execute(['id' => $id]);
    }

    public function deleteToken($userId) {
        try {
            $query = "UPDATE utilisateurs SET token = NULL WHERE id = :id";
            $stmt = $this->connexion->prepare($query);
            $stmt->bindParam(':id', $userId);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erreur lors de la suppression du token : " . $e->getMessage();
            return false;
        }
    }  

    public function updateToken($userId, $token) {
        $query = "UPDATE utilisateurs SET token = :token WHERE id = :id";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':token', $token);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
    }

    public function validateToken($userId, $token) {
        $query = "SELECT * FROM utilisateurs WHERE id = :id AND token = :token";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    

    public function addUser($username, $password, $role)
    {
        // Hachage du mot de passe pour des raisons de sécurité
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Générer un token unique
        $token = bin2hex(random_bytes(32)); // Génère un token aléatoire de 64 caractères hexadécimaux

        $query = "INSERT INTO utilisateurs (username, mot_de_passe, role, token) VALUES (:username, :mot_de_passe, :role, :token)";
        $stmt = $this->connexion->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':mot_de_passe', $hashedPassword);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':token', $token);
        $stmt->execute();
    }
}
?>
