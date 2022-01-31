<?php

require_once 'Model/Manager.php';

class CommentManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function getComments()
    {
        $req = $this->bdd->query('SELECT * FROM comments 
        LEFT JOIN posts ON comments.post_id = posts.id 
        WHERE status_post = 2 ORDER BY comments.id DESC LIMIT 5');
        $comment = $req->fetchAll();

        return $comment;
    }
}
