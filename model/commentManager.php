<?php

namespace blogmvc\model;

class commentManager extends manager
{
    public function __construct()
    {
        $this->bdd = $this->dbConnect();
    }

    public function getComments()
    {
        $req = $this->bdd->query('SELECT * FROM comments 
        LEFT JOIN posts ON comments.post_id = posts.id
        WHERE status_comm = 2 ORDER BY comments.id DESC LIMIT 5');
        $comments = $req->fetchAll();

        return $comments;
    }

    public function commentsPost()
    {
        $req = $this->bdd->query('SELECT * FROM comments 
        WHERE post_id = '. $_GET['id'] .' AND status_comm = 2');
        $countComments = $req->rowCount();

        return $countComments;
    }

    public function countCommentsPost()
    {
        $req = $this->bdd->query('SELECT COUNT(*) AS total FROM comments
        LEFT JOIN posts ON comments.post_id = posts.id   
        WHERE post_id = '. $_GET['id'] .' AND status_comm = 2'); 
        $countCommentsPosts = $req->fetchAll();

        return $countCommentsPosts;
    }

    public function listComments($post_id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_comment, \'%d/%m/%Y\') AS date_comment FROM comments 
        WHERE post_id = ? AND status_comm = 2  ORDER BY date_comment DESC');
        $req->execute(array($post_id));
        $listComments = $req->fetchAll();

        return $listComments;
    }

    public function countComments()
    {
        $req = $this->bdd->query('SELECT * FROM comments');
        $countComments = $req->rowCount();

        return $countComments;
    }

    public function insertComment()
    {
        $req = $this->bdd->prepare('INSERT INTO comments(post_id, name_author, email_author, comment, date_comment) 
        VALUES( :post_id, :name_author, :email_author, :comment, NOW())');
        $insertComment = $req->execute(array(
        'post_id'=> $_GET['id'],
        'name_author'=> $_POST['name_author'],
        'email_author'=> $_POST['email_author'],
        'comment'=> $_POST['comment']
        ));

        return $insertComment;
    }

    public function indexComment()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_comment, \'%d/%m/%Y\') AS date_comment, comments.id AS commentId FROM comments 
        LEFT JOIN posts ON comments.post_id = posts.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE posts.user_id = users.id 
        ORDER BY date_comment DESC');
        $indexComments = $req->fetchAll();

        return $indexComments;
    }

    public function editComment($id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_comment, \'%d/%m/%Y\') AS date_comment FROM comments 
        LEFT JOIN posts ON comments.post_id = posts.id 
        WHERE comments.id = ?');
        $req->execute(array($id));
        $editComment = $req->fetch(\PDO::FETCH_ASSOC);

        return $editComment;
    }

    public function statusComment($status_comm,$id)
    {
        $req = $this->bdd->prepare('UPDATE comments SET status_comm = :status_comm WHERE id = :id');
        $statusComm = $req->execute([
        'status_comm'=> $status_comm,
        'id' => $id                    
        ]);

        return $statusComm;
    }

    public function deleteComment($id)
    {
        $req = $this->bdd->prepare('DELETE FROM comments WHERE id = ?');
        $deleteComment = $req->execute(array($id));

        return $deleteComment;
    }

}