<?php

require_once 'BaseController.php'; 

class FrontendController extends BaseController{

    public function home(){
        echo $this->twig->render("frontend/home.html.twig");
    }

    public function postslist(){
        echo $this->twig->render("frontend/postslist.html.twig");
    }

    public function postsingle(){
        echo $this->twig->render("frontend/postsingle.html.twig");
    }

    public function register(){
        echo $this->twig->render("frontend/register.html.twig");
    }

    public function login(){
        echo $this->twig->render("frontend/login.html.twig");
    }
};