<?php

require_once('Controller/BaseController.php');

class TagsController extends BaseController {

    public function indextag()
    {
        echo $this->twig->render("backend/tags/indextag.html.twig",[
            'activemenu' => 'tagmenu',
        ]);

        if(isset($_SESSION['edittag']) && $_SESSION['edittag'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['edittag'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
        unset($_SESSION['edittag']);
        }

        if(isset($_SESSION['addtag']) && $_SESSION['addtag'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['addtag'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
        unset($_SESSION['addtag']);
        }
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
            
                $_SESSION['addtag'] = 'Creation successfully !'; 

                unset($_SESSION['input']);  
            
                header('Location: index.php?page=indextag');
  
            }
        }

        echo $this->twig->render("backend/tags/addtag.html.twig",[
            'activemenu' => 'tagmenu'
        ]);

        if(!empty($_SESSION['danger'])) {
            ?>
            <script>
                swal({
                title: "You have not completed the post correctly :",
                text: "<?php foreach($_SESSION['danger'] as $danger): ?>
                        <?= $danger.'\n'; ?>
                        <?php endforeach; ?>",
                icon: "error",
                });
            </script>
        <?php
        unset($_SESSION['danger']);
        unset($_SESSION['input']);  
        }    
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
        
                $_SESSION['edittag'] = 'Update successfully !';

                unset($_SESSION['input']);  
            
                header('Location: index.php?page=indextag');
            }
        }

        echo $this->twig->render("backend/tags/edittag.html.twig",[
            'activemenu' => 'tagmenu',
            'tagid' => $tagId
        ]);

        if(!empty($_SESSION['danger'])) {
            ?>
            <script>
                swal({
                title: "You have not completed the post correctly :",
                text: "<?php foreach($_SESSION['danger'] as $danger): ?>
                        <?= $danger.'\n'; ?>
                        <?php endforeach; ?>",
                icon: "error",
                });
            </script>
        <?php
        unset($_SESSION['danger']);
        unset($_SESSION['input']);  
        }    
    }

    public function deletetag()
    {
        $id = $_GET['id'];

        $tagManager = new TagManager();
        $deleteTag = $tagManager->deleteTag($_GET['id']);
        
        if($deleteTag == NULL) {
            $_SESSION['danger'] = "There was a problem with a data processing !";
        }

        header('Location: index.php?page=indextag');
    }
}