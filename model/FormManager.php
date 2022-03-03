<?php

require_once 'Model/Manager.php';

class FormManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function loginUser($username)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE username = ?');
        $req->execute([$username]);
        $user = $req->fetch();
        
        return $user;
    }

    public function registerUsername($username)
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute([$username]);
        $user = $req->fetch();

        return $user;
    }

    public function registerEmail($email)
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$email]);
        $user = $req->fetch();

        return $user;
    }

    public function registerUser($username,$email,$password,$token)
    {
        $req = $this->bdd->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, token_confirm = ?");  
        $req->execute([$username, $email, $password, $token]);
        $user_id = $this->bdd->lastInsertId();
        return $user_id;
    }

}