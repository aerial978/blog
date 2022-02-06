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

}    