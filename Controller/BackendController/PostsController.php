<?php

require_once 'Controller/BaseController.php';
require_once 'model/PostManager.php';

class PostsController extends BaseController{

    public function indexpost(){

        if(isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 1) {

            $postManager = new PostManager();
            $indexposts = $postManager->indexPost1();
            
            } else {

            $postManager = new PostManager();
            $indexposts = $postManager->indexPost2();
        
            }
        
        echo $this->twig->render("backend/posts/indexpost.html.twig",[
            'activemenu' => 'postmenu',
            'indexposts' => $indexposts
        ]);
    }

    public function addpost(){
        echo $this->twig->render("backend/posts/addpost.html.twig");
    }

    public function editpost()
    {
        $errors = array();

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $postManager = new PostManager();
            $editpost = $postManager->editPost($id);

            $tagManager = new TagManager();
            $selectags = $tagManager->selectTag($_GET['id']);

        }
	
        echo $this->twig->render("backend/posts/editpost.html.twig",[
        'editpost' => $editpost,
        'selectags' => $selectags 
        ]);
            
    }

}