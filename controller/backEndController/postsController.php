<?php

require_once 'model/postManager.php';
require_once 'model/tagManager.php';

class postsController
{
    public function indexPost()
    {
        $activeMenu = 'postmenu';

        if(isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 1) {

            $postManager = new postManager();
            $indexPosts = $postManager->indexPost1();
            
            } else {

            $postManager = new postManager();
            $indexPosts = $postManager->indexPost2();
        
            }
        
        require('view/backend/posts/indexpost.php');

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

        if(isset($_SESSION['process']) && $_SESSION['process'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['process'] ?>",
                    icon: 'error',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['process']);
        }
    }

    public function editPost()
    {
        $activeMenu = 'postmenu';
        
        $errors = array();

        if(isset($_GET['id'])) {
        
        $postManager = new postManager();
        $editPost = $postManager->editPost($_GET['id']);

        $tagManager = new tagManager();
        $selectTag = $tagManager->selectTag($_GET['id']);

        } else {

        $errors['id'] = 'You need a post id to change it !';
        
        } 
        
        if (!empty($_POST) && isset($_POST)) {

            
            if(isset($_POST['submit']) && empty($_POST['title']) && $_POST['title'] == '') {
                $errors['title'] = "Enter a title !"; 
            }

            if(isset($_POST['submit']) && empty($_POST['headline']) && $_POST['headline'] == '') {
                $errors['headline'] = "Enter an headline !";
        
            }

            if(isset($_POST['submit']) && empty($_POST['content']) && $_POST['content'] == '') {
                $errors['content'] = "Enter a content !";    
            }

            if(!empty($_FILES['image']['name'])) {
            
                if ($_FILES['image']['error'] > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }
                
                $maxsize = 1000000;
            
                $image = $_FILES['image']['name'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_size = $_FILES['image']['size'];
                $upload_folder = "images/";
            
                if ($image_size >= $maxsize) {
                    $errors['size'] = ''.$image.' is too large ( 1 Mo max ) !';
                }
                
                $image_ext = pathinfo($image,PATHINFO_EXTENSION);
                $image_ext_min = strtolower($image_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
                
                if (!in_array($image_ext_min,$allowed_ext)) {
                    $errors['extension'] = ''.$image.' extension is not allowed ( jpg, jpeg, png and gif only ) !';
                }
            
                if(!isset($errors['size']) && !isset($errors['extension'])) {
                    $_SESSION['picture'] = $_FILES['image'];
                }

                if (empty($errors)) {
                    move_uploaded_file($image_tmp_name, $upload_folder);

                    $postManager = new postManager();
                    $imageUpdate = $postManager->imagePost($image,$_GET['id']);

                }
            }
        
            if(empty($_POST['tag'])) {           
                $errors['tag'] = "Selected a tag !";          
            }

            $_SESSION['errors'] = $errors;

            if(empty($errors)) {
                if(isset($_POST['status_post']) && $_POST['status_post'] == 2) {
                    $status_post = $_POST['status_post'];
                } else {
                    $status_post = 1; 
                }

                $title = $_POST['title'];
                $headline = $_POST['headline']; 
                $content = $_POST['content']; 
                $tag = $_POST['tag'];
                
                $postManager = new postManager();
                $updatePost = $postManager->updatePost($title,$headline,$content,$tag,$status_post,$_GET['id']);

                $_SESSION['update'] = 'Update successfully !';             
                header('Location: index.php?page=indexpost');   
            }
        }
        require('view/backend/posts/editpost.php');
        unset($_SESSION['input']);
        unset($_SESSION['errors']);
        unset($_SESSION['picture']);
        
    }

    public function addPost()
    {
        $tagManager = new tagManager();
        $selectTag = $tagManager->selectTag($_GET['id']);

        if($_POST) {  

            $errors = array();

            if(isset($_POST)) {
                $_SESSION['input'] = $_POST;
            }

            if(isset($_POST['submit']) && empty($_POST['title'])) {
                $errors['title'] = 'Enter a title ! ';
            } 

            if(isset($_POST['submit']) && empty($_POST['headline'])) {
                $errors['headline'] = 'Enter an headline !';
            }

            if(isset($_POST['submit']) && empty($_POST['content'])) {
                $errors['content'] = 'Enter a content !';
            }

            if(isset($_FILES['image']) && $_FILES['image']['size'] == 0) {
                $errors['image'] = 'Select an image !';

            } else if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {

                if ($error = $_FILES['image']['error'] > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $maxsize = 5000000;

                $image = $_FILES['image']['name'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_size = $_FILES['image']['size'];
                $upload_folder = "images/";

                if ($image_size >= $maxsize) {
                    $errors['size'] = 'File too large !';
                }

                $image_ext = pathinfo($image,PATHINFO_EXTENSION);
                $image_ext_min = strtolower($image_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');

                if (!in_array($image_ext_min,$allowed_ext)) {
                    $errors['extension'] = 'file extension is not allowed !'; 
                }
            }

            if (isset($_POST['tag']) &&  $_POST['tag'] == 0) {
                $errors['tag'] = 'Select a tag !';
            }

            $_SESSION['errors'] = $errors;

            if (empty($errors)) {
                $title = $_POST['title'];
                $headline = $_POST['headline']; 
                $content = $_POST['content'];
                $tag = $_POST['tag'];

                if(isset($_POST['status_post']) && $_POST['status_post'] == 2) {
                    $status_post = $_POST['status_post'];
                } else {
                    $status_post = 1; 
                }
                
                move_uploaded_file($image_tmp_name, $upload_folder); 

                $postManager = new postManager();
                $insertPost = $postManager->insertPost($title,$headline,$content,$image,$tag,$status_post);

                $_SESSION['create'] = 'Creation successfully !';       
                header('Location: index.php?page=indexpost');   
            }
        }            
        require('view/backend/posts/addpost.php');
        unset($_SESSION['errors']);
        unset($_SESSION['input']);
    }

    public function deletepost()
    {
        $postManager = new postManager();
        $deletePost = $postManager->deletePost($_GET['id']);

        if($deletePost == NULL) {
            $_SESSION['danger']['process'] = "There was a problem with a data processing !";
        }

        header('Location: index.php?page=indexpost');

    }   
}