<?php

require_once 'BaseController.php';
require_once 'Model/PostManager.php';


class FrontendController extends BaseController{

    public function home()
    {
        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu',
            'posts' => $posts
        ]);

    }

    public function postslist(){
        echo $this->twig->render("frontend/postslist.html.twig",[
            'activemenu' => 'postslistmenu' 
        ]);
    }

    public function postsingle(){
        echo $this->twig->render("frontend/postsingle.html.twig",[
            'activemenu' => 'postslistmenu' 
        ]);
    }

    public function userposts(){
        echo $this->twig->render("frontend/userposts.html.twig",[
            'activemenu' => 'postslistmenu'
        ]);
    }

    public function tagposts(){
        echo $this->twig->render("frontend/tagposts.html.twig",[
            'activemenu' => 'postslistmenu'
        ]);
    }

    public function aside(){

        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        echo $this->twig->render("frontend/partials/asides.html.twig",[
            'posts' => $posts
        ]);
    }

    public function page404(){
        echo $this->twig->render("frontend/page404.html.twig");
    }


    public function register(){
        echo $this->twig->render("frontend/register.html.twig",[
            'activemenu' => 'signupmenu' 
        ]);
    }

    public function login(){
        echo $this->twig->render("frontend/login.html.twig",[
            'activemenu' => 'signinmenu' 
        ]);
    }

    public function forget(){
        echo $this->twig->render("frontend/forget.html.twig");
    }
  
};