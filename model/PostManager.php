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
        $post = $req->FetchAll();

        return $post;
    }

    public function number_words($string, $limit = 25, $fin = ' ...')
    {
    preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
    
    if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
        return $string;
        }
    return rtrim($matches[0]).$fin;

    }
}