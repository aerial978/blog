<?php

require_once 'BaseController.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';
require_once 'model/CommentManager.php';


class FrontendController extends BaseController{

    public function home()
    {
        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu',
        ]);
    }

    public function postslist()
    {
    
        echo $this->twig->render("frontend/postslist.html.twig",[
            'activemenu' => 'postslistmenu',
        ]);
    }

    public function postsingle(){

        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $postManager = new PostManager();
            $post = $postManager->singlePost($_GET['id']);

            if($post == NULL) {
                header('location: ?page=page404');
            }

            $commentManager = new CommentManager();
            $listcomments = $commentManager->listComments($_GET['id']); /* off */

            $commentManager = new CommentManager();
            $countcomments = $commentManager->countComments(); /* off */

            echo $this->twig->render("frontend/postsingle.html.twig",[
                'activemenu' => 'postslistmenu',
                'post' => $post,
                'listcomments' => $listcomments,
                'countcomments' => $countcomments
            ]);

        } else {
            header('location: ?page=page404');
        }
    }

    public function userposts(){

        echo $this->twig->render("frontend/userposts.html.twig",[
            'activemenu' => 'postslistmenu',
        ]);
    }

    public function tagposts(){
        echo $this->twig->render("frontend/tagposts.html.twig",[
            'activemenu' => 'postslistmenu'
        ]);
    }

    public function page404(){
        echo $this->twig->render("frontend/error/page404.html.twig");
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