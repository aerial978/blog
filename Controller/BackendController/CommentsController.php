<?php

require_once('BaseController.php');

class CommentsController extends BaseController{

    public function indexcomment(){
        echo $this->twig->render("indexcomment.html.twig");
    }

    public function editcomment(){
        echo $this->twig->render("editcomment.html.twig");
    }
}