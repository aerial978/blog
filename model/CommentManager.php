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
        WHERE status_comm = 2 ORDER BY comments.id DESC LIMIT 5');
        $comment = $req->fetchAll();

        return $comment;
    }

    public function countcommentsPost()
    {
        $req = $this->bdd->query('SELECT COUNT(*) AS total FROM comments WHERE post_id = '. $_GET['id'] .' AND status_comm = 2'); 
        $countcommentsPosts = $req->fetchAll();

        return $countcommentsPosts;
    }

    public function listComments($post_id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_comment, \'%d/%m/%Y à %H/%i/%s\') AS date_comment FROM comments 
        WHERE post_id = ? AND status_comm = 2  ORDER BY date_comment DESC');
        $req->execute(array($post_id));
        $comments = $req->fetchAll();

        return $comments;
    }

    public function countComments()
    {
        $req = $this->bdd->query('SELECT * FROM comments');
        $countComments = $req->rowCount();

        return $countComments;
    }

}
