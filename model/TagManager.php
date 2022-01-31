<?php

require_once 'Model/Manager.php';

class TagManager extends Manager
{

    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function getTags()
    {

        $req = $this->bdd->query('SELECT * FROM tags ORDER BY id');
        $tag = $req->fetchAll();

        return $tag;
    }

}