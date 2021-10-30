<?php

require_once('Controller/BaseController.php');

class UsersController extends BaseController{

    public function indexuser(){
        echo $this->twig->render("backend/users/indexuser.html.twig");
    }

    public function adduser(){
        echo $this->twig->render("backend/users/adduser.html.twig");
    }

    public function edituser(){
        echo $this->twig->render("backend/user/edituser.html.twig");
    }
}