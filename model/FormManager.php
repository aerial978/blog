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
}
