<?php

require_once 'Model/Manager.php';

class PostManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function getPosts()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE status_post = 2 ORDER BY date_create DESC');
        $post = $req->fetchAll();

        return $post;
    }

    public function singlePost($id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ?'); 
        $req->execute(array($id));
        $singlepost = $req->fetch(PDO::FETCH_ASSOC);

        return $singlepost;
    }

    public function userPost()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE users.id = '.$_GET['id'].' AND status_post = 2 ORDER BY date_create');
        $userposts = $req->fetchAll();

        return $userposts;
    }

    public function tagPost()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE tags.id = '.$_GET['id'].' AND status_post = 2 ORDER BY date_create');
        $tagposts = $req->fetchAll();

        return $tagposts;
    }

    public function countPosts()
    {
        $req = $this->bdd->query('SELECT * FROM posts');
        $countPosts = $req->rowCount();

        return $countPosts;
    }

    public function indexPost1()
    {
        $req = $this->bdd->query('SELECT *, COUNT(comments.id) AS total, posts.id AS postId FROM posts 
        LEFT JOIN users ON posts.user_id = users.id 
        LEFT JOIN comments ON comments.post_id = posts.id
        WHERE posts.user_id = '.$_SESSION['id'].'
        GROUP BY posts.id ORDER BY date_create AND status_post = 2');
        $indexposts = $req->fetchAll();

        return $indexposts;            
    }

    public function indexPost2()
    {
        $req = $this->bdd->query('SELECT *, COUNT(comments.id) AS total, posts.id AS postId FROM posts 
        LEFT JOIN users ON posts.user_id = users.id 
        LEFT JOIN comments ON comments.post_id = posts.id 
        GROUP BY posts.id ORDER BY date_comment AND status_post = 2 DESC');
        $indexposts = $req->fetchAll();
        
        return $indexposts;         
    }

    public function editPost($id)
    {
        $req = $this->bdd->prepare('SELECT * FROM posts LEFT JOIN tags ON posts.tag_id = tags.id WHERE posts.id = ?');
	    $req->execute(array($id));
	    $editpost = $req->fetch(PDO::FETCH_ASSOC);

        return $editpost;
    }

    public function imagePost($image,$id)
    {
        $req = $this->bdd->prepare('UPDATE posts SET image = :image WHERE id = :id');
        $imageUpdate = $req->execute([
        'image' => $image,
        'id' => $id
        ]);

        return $imageUpdate;
    }

    public function updatePost($title,$headline,$content,$tag,$status_post,$id)
    {
        $req = $this->bdd->prepare('UPDATE posts SET title = :title, headline = :headline, content = :content, tag_id = :tag, status_post = :status_post, date_create = NOW() WHERE id = :id');
        $updatePost = $req->execute([
        'title'=> $title,
        'headline'=> $headline,
        'content'=> $content,
        'tag'=> $tag,
        'status_post'=> $status_post,
        'id' => $id
        ]);
        
        return $updatePost;
    
    }

    public function insertPost($title,$headline,$content,$image,$tag,$status_post)
    {
        $req = $this->bdd->prepare("INSERT INTO posts(user_id,tag_id,title,headline,content,image,status_post,date_create) VALUES (:user_id, :tag, :title, :headline, :content, :image, :status_post, NOW())");
        $insertPost = $req->execute([
        'user_id' => $_SESSION['id'],
        'title' => $title,
        'headline' => $headline,
        'content' => $content,
        'image' => $image,
        'tag' => $tag,
        'status_post' => $status_post
        ]);
        
        return $insertPost;


    }

   

}