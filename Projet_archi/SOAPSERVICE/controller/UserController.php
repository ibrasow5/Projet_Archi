<?php

require_once('../persistence/Database.php');
require_once('../domaine/User.php');

class UserController{

    public function UserController(){
        $self = $_SERVER["PHP_SELF"];
        $add = explode("/", $self);
        $this->adresse = "http://". $_SERVER["HTTP_HOST"]. "/".$add[1]."/";
    }

    public function addUser($username, $password, $role)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();

        $request = $bdd->prepare('INSERT INTO users (username, password, role) VALUES(:username, :password, :role)');
        return $request->execute([
            'username' => $username,
            'password' => md5(sha1(str_rot13($password))),
            'role'     => $role
        ]);
    }

    public function removeUser($id)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        return $bdd->exec('DELETE FROM users WHERE id = ' . $id);
    }

    public function getAllUserList()
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        $users = array();

        $request = $bdd->query('SELECT * FROM users');
        while ($data = $request->fetch(PDO::FETCH_ASSOC)) {
            $users[] = $data;
        }

        return $users;
    }

    public function getUserById($id)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        $id = (int) $id;

        $request = $bdd->query('SELECT * FROM users WHERE id = "'.$id.'"');
        $data = $request->fetch(PDO::FETCH_ASSOC);

        $user = ($data === false) ? null : $data;
        return $user;
    }

    public function getUserByEmail($email)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        $request = $bdd->query('SELECT * FROM users WHERE email =  "'.$email.'"');
        $data = $request->fetch(PDO::FETCH_ASSOC);

        $user = ($data === false) ? null : $data;
        return $user;
    }

    public function getUserPassword($id)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        $request = $bdd->query('SELECT password FROM users WHERE id =  '.$id);
        $data = $request->fetch(PDO::FETCH_ASSOC);

        $user = ($data === false) ? null : $data;
        return $user['password'];
    }

    public function updateUser($id, $username, $password, $role)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();

        $id = (int) $id;
        $req_get_pass = $this->getUserPassword($id);

        if ($req_get_pass === md5(sha1(str_rot13($password)))) {
            $request = $bdd->prepare('UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id');
            return $request->execute([
                'username' => $username,
                'password' => $password,
                'role'     => $role,
                'id'       => $id
            ]);
        } else {
            $request = $bdd->prepare('UPDATE users SET username = :username, password = :password, role = :role WHERE id = :id');
            return $request->execute([
                'username' => $username,
                'password' => md5(sha1(str_rot13($password))),
                'role'     => $role,
                'id'       => $id
            ]);
        }
    }

    public function authenticateUser($username, $password)
    {
        $bdd = new Database('localhost', '3306', 'user_management', 'papis', 'passer');
        $bdd->connect();
        $role = 'admin';

        $request = $bdd->prepare('SELECT * FROM users WHERE username = :username and password = :password and role = :role');
        $request->execute([
            'username' => $username,
            'password' => md5(sha1(str_rot13($password))),
            'role'     => $role
        ]);

        return count($request->fetchAll());
    }
}

ini_set('soap.wsdl_cache_enabled', 0);
$serversoap = new SoapServer("http://localhost/soapService/persistence/wsdl/user.wsdl");

$serversoap->setClass("UserController");

$serversoap->handle();
