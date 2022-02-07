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

    public function number_words($string, $limit = 25, $fin = ' ...') /* off */
    {
    preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
    
    if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
        return $string;
        }
    return rtrim($matches[0]).$fin;
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


}