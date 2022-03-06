<?php

require_once 'Model/Manager.php';

class UserManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function getUser()
    {
        $req = $this->bdd->prepare('SELECT username FROM users WHERE id = ?');
        $req->execute([$_GET['id']]);
        $user = $req->fetch();

        return $user;
    }

    public function countUsers()
    {
        $req = $this->bdd->query('SELECT * FROM users');
        $countUsers = $req->rowCount();

        return $countUsers;
    }

    public function tokenUser($user_id,$token)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = ? AND token_confirm = ?');
        $req->execute([$user_id,$token]);
        $tokenUser = $req->fetch();

        return $tokenUser;
    }

    public function tokenConfirm($user_id)
    {
        $req = $this->bdd->prepare('UPDATE users SET token_confirm = NULL, token_date = NOW() WHERE id = ?');
        $tokenConfirm = $req->execute([$user_id]);

        return $tokenConfirm;
    }

    public function indexUser1()
    {
        $req = $this->bdd->query('SELECT * FROM users WHERE username ="'.$_SESSION['username'].'"');
        $indexUsers = $req->fetchAll();

        return $indexUsers;
    }

    public function indexUser2()
    {
        $req = $this->bdd->query('SELECT * FROM users ORDER BY id DESC');
        $indexUsers = $req->fetchAll();

        return $indexUsers;
    }

    public function editUser($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute(array($id));
        $editUser = $req->fetch(PDO::FETCH_ASSOC);

        return $editUser;
    }

    public function updateUsername($username,$id)
    {
        $req = $this->bdd->prepare('UPDATE users SET username = :username WHERE id = :id');
        $updateUsername = $req->execute([
            'username'=> $username,
            'id'=>$id,
        ]);

        return $updateUsername;
    }

    public function updatePicture($picture,$id)
    {
        $req = $this->bdd->prepare('UPDATE users SET picture = :picture WHERE id = :id');
        $updatePicture = $req->execute([
            'picture' => $picture,
            'id' => $id
         ]);

         return $updatePicture;
    }

    public function updateEmail($email,$id)
    {
        $req = $this->bdd->prepare('UPDATE users SET email = :email WHERE id = :id');
        $updateEmail = $req->execute([
            'email'=> strtolower($email),
            'id' => $id
        ]);

        return $updateEmail;
    }

    public function updatePasswordRole($password,$role,$id)
    {
        $req = $this->bdd->prepare("UPDATE users SET password = :password, role = :role, date_signup = NOW() WHERE id = :id");
        $updatePasswordRole = $req->execute([
            'password'=> $password,
            'id' => $id,
            'role' => $role 
        ]);

        return $updatePasswordRole;

    }

}    