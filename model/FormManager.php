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

    public function forgetUser($email)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE email = ? AND token_date IS NOT NULL');
        $req->execute([$email]);
        $forgetUser = $req->fetch();

        return $forgetUser;
    }

    public function updateForget($forget_token,$forgetUser)
    {
        $req = $this->bdd->prepare('UPDATE users SET forget_token = ?, forget_date = NOW() WHERE id = ?');
        $updateForget = $req->execute([$forget_token, $forgetUser['id']]);

        return $updateForget;
    }

    public function resetUser()
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = ? AND forget_token = ? /*AND forget_date > DATE_SUB(NOW(), INTERVAL 60 MINUTE)*/');
        $req->execute([$_GET['id'],$_GET['token']]);
        $resetUser = $req->fetch();

        return $resetUser;
    }

    public function updateReset($password,$resetUser)
    {
        $req = $this->bdd->prepare('UPDATE users SET password = ?, forget_token = NULL, forget_date = NULL WHERE id = ?');
        $updateReset = $req->execute([$password, $resetUser['id']]);

        return $updateReset;
    }

}