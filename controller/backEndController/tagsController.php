<?php

use blogmvc\model\tagManager;

class tagsController extends baseController
{
    public function __construct()
    {
        $this->authentification();
    }
    
    public function indexTag()
    {
        $activeMenu = 'tagmenu';

        $tagManager = new tagManager();
        $listTags = $tagManager->listTags();
        
        require('view/backend/tags/indextag.php');

        if($this->issetSession('create') && $this->getSession('create') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('create') ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('create');
        }

        if($this->issetSession('update') && $this->getSession('update') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= htmlspecialchars($this->getSession('update')) ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('update');
        }
    }

    public function addTag()
    {
        $activeMenu = 'tagmenu';

        if($_POST) {

            $errors = array();
            
            if($this->issetPost()) {
                $this->setSession('input',$_POST);
            }
            
            if($this->issePost('submit') && empty($this->getPost('tagname'))) {
                $errors['name'] = 'Enter a name ! ';
            } else {

                $tagManager = new TagManager();
                $getTagName = $tagManager->getTagName();

                if($getTagName) {
                    $errors['name'] = 'Name already used !';
                } 
            }
            
            if($this->issePost('submit') && empty($this->getPost('description')) && $this->getPost('description') == "") {
                $errors['description'] = 'Enter a description ! ';
            } else {

                $tagManager = new TagManager();
                $getTagDescription= $tagManager->getTagDescription();

                if($getTagDescription) {
                    $errors['description'] = 'Description already used !';
                } 
            }
            
            $this->setSession('errors',$errors);
            
            if(empty($errors)){

                $tagManager = new TagManager();
                $insertTag = $tagManager->insertTag();
            
                $this->setSession('create','Creation successfully !'); 
            
                header('Location: index.php?page=indextag');
            }    
        }
            
        require('view/backend/tags/addtag.php');

        $this->unsetSession('errors');
        $this->unsetSession('input'); 
    }

    public function editTag()
    {
        $activeMenu = 'tagmenu';

        $errors = array();

        $id = $this->getGet('id');

        if($this->issetGet('id')) {

            $tagManager = new TagManager();
            $tagId = $tagManager->tagId($id);

        } else {
            $errors['id'] = 'You need a tag id to change it !';     
        }
            
        if ($this->issetpost()) {

            $this->setSession('input',$_POST);

            if($this->issePost('submit') && empty($this->getPost('name')) && $this->getPost('tagname') == '') {        
                $errors['name'] = "Enter a name !";    
            }

            if($this->issePost('submit') && empty($this->getPost('description')) && $this->getPost('description') == '') {
                $errors['description'] = "Enter a description !";
            }

            $_SESSION['errors'] = $errors;

            if(empty($errors)) {
                $name = $this->getPost('tagname');
                $description = $this->getPost('description');

                $tagManager = new TagManager();
                $updateTag = $tagManager->updateTag($name,$description,$id);
        
                $this->setSession('update','Update successfully !'); 
                header('Location: index.php?page=indextag');
            }
        }            
        require('view/backend/tags/edittag.php');
        $this->unsetSession('errors');
        $this->unsetSession('input');    
    }

    public function deletetag()
    {  
        $tagManager = new tagManager();
        $deleteTag = $tagManager->deleteTag($this->getGet('id'));
        
        if($deleteTag == NULL) {
            $this->setSession('danger','There was a problem with a data processing !'); 
        }
    
        header('Location: index.php?page=indextag');
    }
}