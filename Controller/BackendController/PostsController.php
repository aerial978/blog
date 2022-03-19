<?php

require_once 'Controller/BaseController.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';

class PostsController extends BaseController{

    public function indexpost()
    {

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

        if(isset($_SESSION['editpost']) && $_SESSION['editpost'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['editpost'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['editpost']);
        }

        if(isset($_SESSION['addpost']) && $_SESSION['addpost'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['addpost'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['addpost']);
            }
    }

    public function addpost()
    {
        if($_POST) {  

            $_SESSION['danger'] = array();

            if(isset($_POST)) {
                $_SESSION['input'] = $_POST;
            }
            
            if(isset($_POST['submit']) && empty($_POST['title'])) {
                $_SESSION['danger']['title'] = "Enter a title ! ";
            } 
            
            if(isset($_POST['submit']) && empty($_POST['headline'])) {
                $_SESSION['danger']['headline'] = "Enter an headline !";
            }
            
            if(isset($_POST['submit']) && empty($_POST['content'])) {
                $_SESSION['danger']['content'] = "Enter a content !";
            }
            
            if(isset($_FILES['image']) && $_FILES['image']['size'] == 0) {
                $_SESSION['danger']['image'] = "Select an image !";
            
            } else if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
            
                if ($_FILES['image']['error'] > 0) {
                    $_SESSION['danger']['transfer'] = "There was a problem with the transfer !";
                }
            
                $maxsize = 1000000;
            
                $image = $_FILES['image']['name'];
                $image_tmp_name = $_FILES['image']['tmp_name'];
                $image_size = $_FILES['image']['size'];
                $upload_folder = "images/";
            
                if ($image_size >= $maxsize) {
                    $_SESSION['danger']['size'] = "$image is too large ( 1 Mo max ) !";
                }
            
                $image_ext = pathinfo($image,PATHINFO_EXTENSION);
                $image_ext_min = strtolower($image_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
            
                if (!in_array($image_ext_min,$allowed_ext)) {
                    $_SESSION['danger']['extension'] = "$image : extension is not allowed ( jpg, jpeg, png and gif only ) !"; 
                }
            }
            
            if (isset($_POST['tag']) &&  $_POST['tag'] == 0) {
                $_SESSION['danger']['tag'] = "Select a tag !";
            }
            
            if (empty($_SESSION['danger'])) {
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
                
                $postManager = new PostManager();
                $insertPost = $postManager->insertPost($title,$headline,$content,$image,$tag,$status_post);

                if($insertPost == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }

                $_SESSION['addpost'] = 'Creation success !';
     
                header('Location: index.php?page=indexpost');   
            }
        }

        $tagManager = new TagManager();
        $selectTags = $tagManager->selectTag($_GET['id']);

        echo $this->twig->render("backend/posts/addpost.html.twig",[
            'activemenu' => 'postmenu',
            'selectags' => $selectTags 
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
        }        
    }

    public function editpost()
    {
        $_SESSION['danger'] = array();

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $postManager = new PostManager();
            $editPost = $postManager->singlePost($id);

        } else {

            array_push($_SESSION['danger']['id'], "You need a post id to change it !");
            
        }

        if($_SESSION['auth_role'] == 1 || $_SESSION['id'] = $editPost['id']) {
        
            if (!empty($_POST) && isset($_POST)) {
            
                $_SESSION['input'] = $_POST;
                
                if(isset($_POST['submit']) && empty($_POST['title']) && $_POST['title'] == '') {
                
                    $_SESSION['danger']['title'] = "Enter a title !";
                
                }
            
                if(isset($_POST['submit']) && empty($_POST['headline']) && $_POST['headline'] == '') {
            
                    $_SESSION['danger']['headline'] = "Enter an headline !";
                
                }
            
                if(isset($_POST['submit']) && empty($_POST['content']) && $_POST['content'] == '') {
            
                    $_SESSION['danger']['content'] = "Enter a content !";
                
                }
            
                if(!empty($_FILES['image']['name'])) {

                    if ($_FILES['image']['error'] > 0) {
                        $_SESSION['danger']['transfer'] = "There was a problem with the transfer !";
                    }
                    
                    $maxsize = 1000000;
                
                    $image = $_FILES['image']['name'];
                    $image_tmp_name = $_FILES['image']['tmp_name'];
                    $image_size = $_FILES['image']['size'];
                    $upload_folder = "images/";
                
                    if ($image_size >= $maxsize) {
                        $_SESSION['danger']['size'] = "$image is too large ( 1 Mo max ) !";
                    }
                    
                    $image_ext = pathinfo($image,PATHINFO_EXTENSION);
                    $image_ext_min = strtolower($image_ext);
                    $allowed_ext = array('jpg','jpeg','png','gif');
                    
                    if (!in_array($image_ext_min,$allowed_ext)) {
                        $_SESSION['danger']['extension'] = "$image : extension is not allowed ( jpg, jpeg, png and gif only ) !";
                    }
                
                    if(!isset($_SESSION['danger']['size']) && !isset($_SESSION['danger']['extension'])) {
                        $_SESSION['pictures'] = $_FILES['image'];
                    }
            
                    if (empty($_SESSION['danger'])) {
                        move_uploaded_file($image_tmp_name, $upload_folder);
                        
                        $postManager = new PostManager();
                        $imageUpdate = $postManager->imagePost($image,$_GET['id']);

                        if($imageUpdate == NULL) {
                            $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                        }
                    }
                }
            
                if(empty($_POST['tag'])) {
                    
                    $_SESSION['danger']['tag'] = "Selected a tag !";          
                }
            
                if(empty($_SESSION['danger'])) {
                    if(isset($_POST['status_post']) && $_POST['status_post'] == 2) {
                        $status_post = $_POST['status_post'];
                    } else {
                        $status_post = 1; 
                    }
            
                    $title = $_POST['title'];
                    $headline = $_POST['headline']; 
                    $content = $_POST['content']; 
                    $tag = $_POST['tag'];
    
                    $postManager = new PostManager();
                    $updatePost = $postManager->updatePost1($title,$headline,$content,$tag,$_GET['id']);

                    if($updatePost == NULL) {
                        $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                    }
            
                    $_SESSION['editpost'] = 'Update success !';

                    unset($_SESSION['input']);
                
                    header('Location: index.php?page=indexpost');

                } else {
                    header('Location: index.php?page=editpost&id='.$_GET['id']);
                }
            }

        } else {
            if (!empty($_POST) && isset($_POST)) {

                if(isset($_POST['status_post']) && $_POST['status_post'] == 2) {
                    $status_post = $_POST['status_post'];
                } else {
                    $status_post = 1; 
                }
            
                $postManager = new PostManager();
                $updatePost = $postManager->updatePost2($status_post,$_GET['id']);
            
                $_SESSION['editpost'] = 'Update success !'; 
                
                header('Location: index.php?page=indexpost');
                }
            }
                
        $tagManager = new TagManager();
        $selectTags = $tagManager->selectTag($_GET['id']);

        echo $this->twig->render("backend/posts/editpost.html.twig",[
        'activemenu' => 'postmenu',
        'editpost' => $editPost,
        'selectags' => $selectTags 
        ]);       
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