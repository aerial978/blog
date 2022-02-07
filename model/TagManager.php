<?php

require_once 'Model/Manager.php';

class TagManager extends Manager
{

    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function listTags()
    {

        $req = $this->bdd->query('SELECT * FROM tags ORDER BY id');
        $listtag = $req->fetchAll();

        return $listtag;
    }


    public function getTag()
    {
        $req = $this->bdd->prepare('SELECT name FROM tags WHERE id = ?');
        $req->execute([$_GET['id']]);
        $tag = $req->fetch();

        return $tag;

    }


}