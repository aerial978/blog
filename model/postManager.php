<?php

class postManager extends manager
{
    public function __construct()
    {
        $this->bdd = $this->dbConnect();
    }

    public function getPosts()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE status_post = 2 ORDER BY date_create DESC LIMIT 5');
        $posts = $req->fetchAll();

        return $posts;
    }

    public function singlePost($id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ?'); 
        $req->execute(array($id));
        $singlePost = $req->fetch(PDO::FETCH_ASSOC);

        return $singlePost;
    }

    public function userPost()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE users.id = '.$_GET['id'].' AND status_post = 2 ORDER BY date_create');
        $userPosts = $req->fetchAll();

        return $userPosts;
    }

    public function tagPost()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE tags.id = '.$_GET['id'].' AND status_post = 2 ORDER BY date_create');
        $tagPosts = $req->fetchAll();

        return $tagPosts;
    }

    public function countPosts()
    {
        $req = $this->bdd->query('SELECT * FROM posts');
        $countPosts = $req->rowCount();

        return $countPosts;
    }

    public function indexPost1()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, COUNT(comments.id) AS total, posts.id AS postId FROM posts 
        LEFT JOIN users ON posts.user_id = users.id 
        LEFT JOIN comments ON comments.post_id = posts.id
        WHERE posts.user_id = '.$_SESSION['id'].'
        GROUP BY posts.id ORDER BY date_create DESC');
        $indexPosts = $req->fetchAll();

        return $indexPosts;            
    }

    public function indexPost2()
    {
        $req = $this->bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, COUNT(comments.id) AS total, posts.id AS postId FROM posts 
        LEFT JOIN users ON posts.user_id = users.id 
        LEFT JOIN comments ON comments.post_id = posts.id 
        GROUP BY posts.id ORDER BY date_create DESC');
        $indexPosts = $req->fetchAll();
        
        return $indexPosts;         
    }

    public function editPost($id)
    {
        $req = $this->bdd->prepare('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE posts.id = ?'); 
        $req->execute(array($id));
        $editPost = $req->fetch(PDO::FETCH_ASSOC);

        return $editPost;
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

    public function deletePost($id)
    {
        $req = $this->bdd->query("DELETE FROM posts WHERE id = $id");
        $deletePost = $req->execute();

        return $deletePost;
    }

}
