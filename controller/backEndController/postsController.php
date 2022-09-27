<?php

use blogmvc\model\postManager;
use blogmvc\model\tagManager;

class postsController extends baseController
{
    public function __construct()
    {
        $this->authentification();
    }

    public function indexPost()
    {
        $activeMenu = 'postmenu';

        if ($this->issetSession('auth', 'role') && $this->getSession('auth', 'role') == 1) {

            $postManager = new postManager();
            $indexPosts = $postManager->indexPost1();
        } else {

            $postManager = new postManager();
            $indexPosts = $postManager->indexPost2();
        }

        require('view/backend/posts/indexpost.php');

        if ($this->issetSession('create') && $this->getSession('create') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('create'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('create');
        }

        if ($this->issetSession('update') && $this->getSession('update') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('update'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('update');
        }

        if ($this->issetSession('process') && $this->getSession('process') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('process'); ?>",
                    icon: 'error',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
<?php
            $this->unsetSession('process');
        }
    }

    public function editPost()
    {
        $activeMenu = 'postmenu';

        $errors = array();

        if ($this->issetGet('id')) {

            $postManager = new postManager();
            $editPost = $postManager->editPost($this->getGet('id'));

            $tagManager = new tagManager();
            $selectTag = $tagManager->selectTag();
        } else {

            $errors['id'] = 'You need a post id to change it !';
        }

        if ($this->issetPost()) {

            if ($this->issePost('submit') && empty($this->getPost('title')) && $this->getPost('title') == '') {
                $errors['title'] = "Enter a title !";
            }

            if ($this->issePost('submit') && empty($this->getPost('headline')) && $this->getPost('headline') == '') {
                $errors['headline'] = "Enter an headline !";
            }

            if ($this->issePost('submit') && empty($this->getPost('content')) && $this->getPost('content') == '') {
                $errors['content'] = "Enter a content !";
            }

            if (!empty($this->getFiles('image', 'name'))) {

                if ($this->getFiles('image', 'error') > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $maxsize = 5000000;

                $image = $this->getFiles('image', 'name');
                $image_tmp_name = $this->getFiles('image', 'tmp_name');
                $image_size = $this->getFiles('image', 'size');
                $upload_folder = "assets/images/";

                if ($image_size >= $maxsize) {
                    $errors['size'] = '' . $image . ' is too large (5 Mo max) !';
                }

                $image_ext = pathinfo($image, PATHINFO_EXTENSION);
                $image_ext_min = strtolower($image_ext);
                $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($image_ext_min, $allowed_ext)) {
                    $errors['extension'] = '' . $image . ' extension is not allowed ( jpg, jpeg, png and gif only ) !';
                }

                if (!isset($errors['size']) && !isset($errors['extension'])) {
                    $this->setSession('picture', $this->getFiles('image'));
                    /*$_SESSION['picture'] = $_FILES['image'];*/
                }

                if (empty($errors)) {
                    move_uploaded_file($image_tmp_name, $upload_folder.$image);

                    $postManager = new postManager();
                    $imageUpdate = $postManager->imagePost($image, $this->getGet('id'));
                }
            }

            if (empty($this->getPost('tagname'))) {
                $errors['tag'] = "Selected a tag !";
            }

            $this->setSession('errors', $errors);

            if (empty($errors)) {
                if ($this->issetPost('status_post') && $this->getPost('status_post') == 2) {
                    $status_post = $this->getPost('status_post');
                } else {
                    $status_post = 1;
                }

                $title = $this->getPost('title');
                $headline = $this->getPost('headline');
                $content = $this->getPost('content');
                $tag = $this->getPost('tagname');

                $postManager = new postManager();
                $updatePost = $postManager->updatePost($title, $headline, $content, $tag, $status_post, $this->getGet('id'));

                $this->setSession('update', 'Update successfully !');
                header('Location: index.php?page=indexpost');
            }
        }
        require('view/backend/posts/editpost.php');
        $this->unsetSession('input');
        $this->unsetSession('errors');
        $this->unsetSession('picture');
    }

    public function addPost()
    {
        $activeMenu = 'postmenu';
        
        if ($_POST) {

            $errors = array();

            if ($this->issetPost()) {
                $this->setSession('input', $_POST);
            }

            if ($this->issePost('submit') && empty($this->getPost('title'))) {
                $errors['title'] = 'Enter a title ! ';
            }

            if ($this->issePost('submit') && empty($this->getPost('headline'))) {
                $errors['headline'] = 'Enter an headline !';
            }

            if ($this->issePost('submit') && empty($this->getPost('content'))) {
                $errors['content'] = 'Enter a content !';
            }

            if ($this->issetFiles('image') && $this->getFiles('image', 'size') == 0) {
                $errors['image'] = 'Select an image !';
            } else if ($this->issetFiles('image') && $this->getFiles('image', 'size') > 0) {

                if ($error = $this->getFiles('image', 'error') > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $image = $this->getFiles('image', 'name');
                $image_tmp_name = $this->getFiles('image', 'tmp_name');
                $image_size = $this->getFiles('image', 'size');
                $upload_folder = "assets/images/";

                $maxsize = 5000000;

                if ($image_size >= $maxsize) {
                    $errors['size'] = 'File too large (5 Mo max) !';
                }

                $image_ext = pathinfo($image, PATHINFO_EXTENSION);
                $image_ext_min = strtolower($image_ext);
                $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($image_ext_min, $allowed_ext)) {
                    $errors['extension'] = 'file extension is not allowed !';
                }
            }

            if ($this->issetPost('tagname') &&  $this->getPost('tagname') == 0) {
                $errors['tag'] = 'Select a tag !';
            }

            $this->setSession('errors', $errors);

            if (empty($errors)) {
                $title = $this->getPost('title');
                $headline = $this->getPost('headline');
                $content = $this->getPost('content');
                $tag = $this->getPost('tagname');

                if ($this->issetPost('status_post') && $this->getPost('status_post') == 2) {
                    $status_post = $this->getPost('status_post');
                } else {
                    $status_post = 1;
                }

                move_uploaded_file($image_tmp_name, $upload_folder.$image);

                $postManager = new postManager();
                $insertPost = $postManager->insertPost($title, $headline, $content, $image, $tag, $status_post);

                $this->setSession('create', 'Creation successfully !');
                header('Location: index.php?page=indexpost');
            }
        }

        $tagManager = new tagManager();
        $selectTag = $tagManager->selectTag();

        require('view/backend/posts/addpost.php');
        $this->unsetSession('errors');
        $this->unsetSession('input');
    }

    public function deletepost()
    {
        if ($this->issetGet('id') && !empty($this->getGet('id'))) {

            $postManager = new postManager();
            $singlePost = $postManager->singlePost($this->getGet('id'));

            if($singlePost['id'] != $this->getSession('auth')['id']) {

                $to         = $singlePost['email'];
                $subject    = 'Your post on a blog';
                $message    = 'We are sorry that your post was not accepted.';
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'From: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                mail($to, $subject, $message, $headers);
                
            }

            $postManager = new postManager();
            $deletePost = $postManager->deletePost($this->getGet('id'));

            if ($deletePost == null) {
                $this->setSession('process', 'There was a problem with a data processing !');
            }

            header('Location: index.php?page=indexpost');
        }
    }
}
