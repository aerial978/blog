<?php

require_once('Controller/BaseController.php');

class PostsController extends BaseController{

    public function indexpost(){
        echo $this->twig->render("backend/posts/indexpost.html.twig");
    }

    public function addpost(){
        echo $this->twig->render("backend/posts/addpost.html.twig");
    }

    public function editpost(){
        echo $this->twig->render("backend/posts/editpost.html.twig");
    }
}