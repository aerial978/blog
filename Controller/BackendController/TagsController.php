<?php

require_once('Controller/BaseController.php');

class TagsController extends BaseController {

    public function indextag()
    {
        echo $this->twig->render("backend/tags/indextag.html.twig",[
            'activemenu' => 'tagmenu',
        ]);
    }

    public function addtag(){
        echo $this->twig->render("backend/tags/addtag.html.twig",[
            'activemenu' => 'tagmenu'
        ]);
    }

    public function edittag()
    {
        $_SESSION['danger'] = array();

        $id = $_GET['id'];

        if(isset($_GET['id'])) {

            $tagManager = new TagManager();
            $tagId = $tagManager->tagId($id);

        } else {

            array_push($_SESSION['danger'],"You need a tag id to change it !");
            
        }
            
        if (!empty($_POST) && isset($_POST)) {

            $_SESSION['input'] = $_POST;

            if(isset($_POST['submit']) && empty($_POST['name']) && $_POST['name'] == '') {
                
                array_push($_SESSION['danger'],"Enter a name !");
                
            }

            if(isset($_POST['submit']) && empty($_POST['description']) && $_POST['description'] == '') {

                array_push($_SESSION['danger'], "Enter a description !");

            }

            if(empty($_SESSION['danger'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                $tagManager = new TagManager();
                $updateTag = $tagManager->updateTag($name,$description,$id);

                if($updateTag == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }
        
                $_SESSION['updatetag'] = 'Update success !';
            
                header('Location: index.php?page=indextag');

                unset($_SESSION['danger']);
                unset($_SESSION['input']);

            }
        }

        echo $this->twig->render("backend/tags/edittag.html.twig",[
            'activemenu' => 'tagmenu',
            'tagid' => $tagId
        ]);
    }
}