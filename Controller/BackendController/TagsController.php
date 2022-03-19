<?php

require_once('Controller/BaseController.php');

class TagsController extends BaseController {

    public function indextag()
    {
        echo $this->twig->render("backend/tags/indextag.html.twig",[
            'activemenu' => 'tagmenu',
        ]);
    }

    public function addtag()
    {
        if($_POST) {

            $_SESSION['danger'] = array();
            
            if(isset($_POST)) {
                $_SESSION['input'] = $_POST;
            }
            
            if(isset($_POST['submit']) && empty($_POST['name'])) {
                $_SESSION['danger']['name'] = "Enter a name !";
            } else {
                
                $tagManager = new TagManager();
                $getTagName = $tagManager->getTagName();

                if($getTagName) {
                    $_SESSION['danger']['name_used'] =  "Name already used !";
                } 
            }
            
            if(isset($_POST['submit']) && empty($_POST['description']) && $_POST['description'] == "") {
                $_SESSION['danger']['description'] = "Enter a description !";
            } else {
                $tagManager = new TagManager();
                $getTagDescription= $tagManager->getTagDescription();

                if($getTagDescription) {
                    $_SESSION['danger']['description_used'] = "Description already used !";
                } 
            }
            
            if(empty($_SESSION['danger'])){

                $tagManager = new TagManager();
                $insertTag = $tagManager->insertTag();

                if($insertTag == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }
            
                $_SESSION['addtag'] = 'Creation success !'; 
            
                header('Location: index.php?page=indextag');

                unset($_SESSION['danger']);
                unset($_SESSION['input']);    
            }
        }

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

            $_SESSION['danger']['id'] = "You need a tag id to change it !";
            
        }
            
        if (!empty($_POST) && isset($_POST)) {

            $_SESSION['input'] = $_POST;

            if(isset($_POST['submit']) && empty($_POST['name']) && $_POST['name'] == '') {
                
                $_SESSION['danger']['name'] = "Enter a name !";
                
            }

            if(isset($_POST['submit']) && empty($_POST['description']) && $_POST['description'] == '') {

                $_SESSION['danger']['description'] = "Enter a description !";

            }

            if(empty($_SESSION['danger'])) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                $tagManager = new TagManager();
                $updateTag = $tagManager->updateTag($name,$description,$id);

                if($updateTag == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }
        
                $_SESSION['updatetag'] = 'Update success !';
            
                header('Location: index.php?page=indextag');
            }
        }

        echo $this->twig->render("backend/tags/edittag.html.twig",[
            'activemenu' => 'tagmenu',
            'tagid' => $tagId
        ]);
    }

    public function deletetag()
    {
        $id = $_GET['id'];

        $tagManager = new TagManager();
        $deleteTag = $tagManager->deleteTag($id);
        
        if($deleteTag == NULL) {
            $_SESSION['danger'] = "There was a problem with a data processing !";
        }

        header('Location: index.php?page=indextag');
    }
}