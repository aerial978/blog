<?php

namespace blogmvc\model;

class formManager extends manager
{
    public function __construct()
    {
        $this->bdd = $this->dbConnect();
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
        $registerUsername = $req->fetch();

        return $registerUsername;
    }

    public function registerEmail($email)
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$email]);
        $registerEmail = $req->fetch();

        return $registerEmail;
    }

    public function registerUser($username,$email,$password,$token)
    {
        $req = $this->bdd->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, token_confirm = ?, token_date = NOW()");  
        $req->execute([$username, $email, $password, $token]);
        $user_id = $this->bdd->lastInsertId();
        return $user_id;
    }

    public function tokenUser($user_id,$token)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = ? AND token_confirm = ? AND token_date > DATE_SUB(NOW(), INTERVAL 60 MINUTE)');
        $req->execute([$user_id,$token]);
        $tokenUser = $req->fetch();

        return $tokenUser;
    }

    public function tokenConfirm($user_id)
    {
        $req = $this->bdd->prepare('UPDATE users SET activation = 1, token_confirm = NULL, token_date = NULL WHERE id = ?');
        $tokenConfirm = $req->execute([$user_id]);

        return $tokenConfirm;
    }

    public function forgetUser($email)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE email = ?');
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
        $req = $this->bdd->prepare('SELECT * FROM users WHERE id = ? AND forget_token = ? AND forget_date > DATE_SUB(NOW(), INTERVAL 60 MINUTE)');
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