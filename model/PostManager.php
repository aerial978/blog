<?php

namespace Hathier\Blog\Model;

require_once("model/Manager.php");

class PostManager extends Manager
{
    public function getPosts()
    {
        $req = $bdd->query('SELECT *, DATE_FORMAT(date_create, \'%d/%m/%Y\') AS date_create, posts.id AS postId FROM posts 
        LEFT JOIN tags ON posts.tag_id = tags.id 
        LEFT JOIN users ON posts.user_id = users.id 
        WHERE status_post = 2 ORDER BY date_create DESC');

        return $req;
    }
}