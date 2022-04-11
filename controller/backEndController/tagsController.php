<?php

class tagsController
{
    public function indexTag()
    {
        $activeMenu = 'tagmenu';

        $tagManager = new tagManager();
        $listTags = $tagManager->listTags();
        
        require('view/backend/tags/indextag.php');

        if(isset($_SESSION['create']) && $_SESSION['create'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['create'] ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['create']);
        }

        if(isset($_SESSION['update']) && $_SESSION['update'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['update'] ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['update']);
        }
    }

    public function addTag()
    {
        $activeMenu = 'tagmenu';

        if($_POST) {

            $errors = array();
            
            if(isset($_POST)) {
                $_SESSION['input'] = $_POST;
            }
            
            if(isset($_POST['submit']) && empty($_POST['name'])) {
                $errors['name'] = 'Enter a name ! ';
            } else {

                $tagManager = new TagManager();
                $getTagName = $tagManager->getTagName();

                if($getTagName) {
                    $errors['name'] = 'Name already used !';
                } 
            }
            
            if(isset($_POST['submit']) && empty($_POST['description']) && $_POST['description'] == "") {
                $errors['description'] = 'Enter a description ! ';
            } else {

                $tagManager = new TagManager();
                $getTagDescription= $tagManager->getTagDescription();

                if($getTagDescription) {
                    $errors['description'] = 'Description already used !';
                } 
            }
            
            $_SESSION['errors'] = $errors;
            
            if(empty($errors)){

                $tagManager = new TagManager();
                $insertTag = $tagManager->insertTag();
            
                $_SESSION['create'] = 'Creation successfully !'; 
            
                header('Location: index.php?page=indextag');
            }    
        }
            
        require('view/backend/tags/addtag.php');

        unset($_SESSION['errors']);
        unset($_SESSION['input']); 
    }

    public function editTag()
    {
        $activeMenu = 'tagmenu';

        $errors = array();

        $id = $_GET['id'];

        if(isset($_GET['id'])) {

            $tagManager = new TagManager();
            $tagId = $tagManager->tagId($id);

        } else {
            $errors['id'] = 'You need a tag id to change it !';     
        }
            
        if (!empty($_POST) && isset($_POST)) {

            $_SESSION['input'] = $_POST;

            if(isset($_POST['submit']) && empty($_POST['name']) && $_POST['name'] == '') {        
                $errors['name'] = "Enter a name !";    
            }

            if(isset($_POST['submit']) && empty($_POST['description']) && $_POST['description'] == '') {
                $errors['description'] = "Enter a description !";
            }

            $_SESSION['errors'] = $errors;

            if(empty($errors)) {
                $name = $_POST['name'];
                $description = $_POST['description'];

                $tagManager = new TagManager();
                $updateTag = $tagManager->updateTag($name,$description,$id);
        
                $_SESSION['update'] = 'Update successfully !';
                header('Location: index.php?page=indextag');
            }
        }            
        require('view/backend/tags/edittag.php');
        unset($_SESSION['errors']);
        unset($_SESSION['input']);    
    }

    public function deletetag()
    {  
        $tagManager = new tagManager();
        $deleteTag = $tagManager->deleteTag($_GET['id']);
        
        if($deleteTag == NULL) {
            $_SESSION['danger'] = "There was a problem with a data processing !";
        }
    
        header('Location: index.php?page=indextag');
    }
}