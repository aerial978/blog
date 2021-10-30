<?php

require_once('Controller/BaseController.php');

class CommentsController extends BaseController{

    public function indexcomment(){
        echo $this->twig->render("backend/comments/indexcomment.html.twig");
    }

    public function editcomment(){
        echo $this->twig->render("backend/comments/editcomment.html.twig");
    }
}