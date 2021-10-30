<?php

require_once('BaseController.php');

class PostsController extends BaseController{

    public function indexpost(){
        echo $this->twig->render("indexpost.html.twig");
    }

    public function addpost(){
        echo $this->twig->render("addpost.html.twig");
    }

    public function editpost(){
        echo $this->twig->render("editpost.html.twig");
    }
}