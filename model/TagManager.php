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

    public function selectTag($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM tags');
        $req->execute(array($id));
        $selectTags = $req->fetchAll(PDO::FETCH_ASSOC);

        return $selectTags;
    }

    public function countTags()
    {
        $req = $this->bdd->query('SELECT * FROM tags');
        $countTags = $req->rowCount();

        return $countTags;
    }

    public function tagId($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM tags WHERE id = ?');
        $req->execute(array($id));
        $tagId = $req->fetch(PDO::FETCH_ASSOC);

        return $tagId;
    }

    public function updateTag($name,$description,$id)
    {
        $req = $this->bdd->prepare("UPDATE tags SET name = :name, description = :description WHERE id = :id");
        $updateTag = $req->execute([
        'name'=> $name,
        'description' => $description,
        'id' => $id
        ]);

        return $updateTag;
    }   
}