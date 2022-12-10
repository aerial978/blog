<?php

namespace blogmvc\model;

class UserManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->dbConnect();
    }

    public function getUsername()
    {
        $req = $this->bdd->prepare('SELECT name FROM users WHERE id = ?');
        $req->execute([$_GET['id']]);
        $getUsername = $req->fetch();

        return $getUsername;
    }

    public function countUsers()
    {
        $req = $this->bdd->query('SELECT * FROM users');
        $countUsers = $req->rowCount();

        return $countUsers;
    }

    public function indexUser1()
    {
        $req = $this->bdd->query('SELECT * FROM users WHERE username ="'.$_SESSION['auth']['username'].'"');
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
        $editUser = $req->fetch(\PDO::FETCH_ASSOC);

        return $editUser;
    }

    public function updateUsername($username,$id)
    {
        $req=$this->bdd->prepare('UPDATE users SET username = :username WHERE id = :id');
        $updateUsername = $req->execute([
        'username'=> $username,
        'id'=>$id
        ]);

        return $updateUsername;
    }

    public function updateName($name,$id)
    {
        $req=$this->bdd->prepare('UPDATE users SET name = :name WHERE id = :id');
        $updateName = $req->execute([
        'name'=> $name,
        'id'=>$id
        ]);

        return $updateName;
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
            'role' => $role,
            'id' => $id
        ]);

        return $updatePasswordRole;
    }

    public function updateRole($role,$id)
    {
        $req = $this->bdd->prepare("UPDATE users SET role = :role, date_signup = NOW() WHERE id = :id");
        $updateRole = $req->execute([
            'role' => $role,
            'id' => $id
        ]);

        return $updateRole;
    }

    public function getUserId()
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute([$_POST['username']]);
        $getUserId = $req->fetch();

        return $getUserId;
    }

    public function getUserIdName()
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE name = ?");
        $req->execute([$_POST['name']]);
        $getUserIdName = $req->fetch();

        return $getUserIdName;
    }

    public function getUserEmail()
    {
        $req = $this->bdd->prepare("SELECT ID FROM users WHERE email = ?");
        $req->execute([$_POST['email']]);
        $getUserEmail = $req->fetch();

        return $getUserEmail;
    }

    public function insertUser($password,$role)
    {
        $req = $this->bdd->prepare("INSERT INTO users (username,name,picture,email,password,role,activation) VALUES (?,?,?,?,?,?,1)");    
        $insertUser = $req->execute([$_POST['username'],$_POST['name'],$_POST['picture'],$_POST['email'],$password,$role]);

        return $insertUser;
    }

    public function deleteUser($id)
    {
    $req = $this->bdd->query("DELETE FROM users WHERE id = $id");
    $req->execute();

    return $req->rowCount();
    }



}