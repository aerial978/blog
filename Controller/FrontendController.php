<?php

require_once 'BaseController.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';
require_once 'model/CommentManager.php';


class FrontendController extends BaseController{

    public function home()
    {
        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        $tagManager = new TagManager();
        $tags = $tagManager->getTags();

        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();

        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu',
            'posts' => $posts,
            'tags' => $tags,
            'comments' => $comments
        ]);

    }

    public function postslist()
    {

        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        $tagManager = new TagManager();
        $tags = $tagManager->getTags();

        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();

        echo $this->twig->render("frontend/postslist.html.twig",[
            'activemenu' => 'postslistmenu',
            'posts' => $posts,
            'tags' => $tags,
            'comments' => $comments

        ]);
    }

    public function postsingle(){

        $postManager = new PostManager();
        $singleposts = $postManager->singlePost($_GET['id']);

        $postManager = new PostManager();
        $posts = $postManager->getPosts();

        $tagManager = new TagManager();
        $tags = $tagManager->getTags();

        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();

        echo $this->twig->render("frontend/postsingle.html.twig",[
            'activemenu' => 'postslistmenu',
            'singleposts' => $singleposts,
            'posts' => $posts,
            'tags' => $tags,
            'comments' => $comments
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