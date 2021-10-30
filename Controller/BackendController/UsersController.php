<?php

require_once('BaseController.php');

class UsersController extends BaseController{

    public function indexuser(){
        echo $this->twig->render("indexuser.html.twig");
    }

    public function adduser(){
        echo $this->twig->render("adduser.html.twig");
    }

    public function edituser(){
        echo $this->twig->render("edituser.html.twig");
    }
}