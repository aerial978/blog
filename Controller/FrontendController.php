<?php

namespace Hathier\Blog\Model;
namespace Hathier\Blog\Controller;

class FrontendController extends BaseController{

    public function home()
    {

        function post()
        {

        $postManager = new PostManager();
        $data = $postManager->getPosts();

        require('view/frontend/home.html.twig');

        }    

        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu'
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