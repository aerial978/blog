<?php

require_once('Controller/BaseController.php');

class UsersController extends BaseController{

    public function indexuser()
    {
        if(isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 1) {

            $userManager = new UserManager();
            $indexUsers = $userManager->indexUser1();

            } else {
            
                $userManager = new UserManager();
                $indexUsers = $userManager->indexUser2();
            }
            
        echo $this->twig->render("backend/users/indexuser.html.twig",[
            'activemenu' => 'usermenu',
            'indexusers' => $indexUsers
        ]);

        if(isset($_SESSION['updateuser']) && $_SESSION['updateuser'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['updateuser'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['updateuser']);
            }
    }

    public function adduser()
    {
        $_SESSION['danger'] = array();

        $_SESSION['input'] = $_POST;

        if (!empty($_POST)) {

            if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {

                array_push($_SESSION['danger'], "Invalid username !");

            } else {
                
                $userManager = new UserManager();
                $getUserId = $userManager->getUserId();

                if($getUserId) {
                    array_push($_SESSION['danger'], "Username already used !");
                } 
            }

            if(isset($_FILES['picture']) && $_FILES['picture']['size'] == 0) {
                array_push($_SESSION['danger'], "Select an image !");
            
            } else if (isset($_FILES['picture']) && $_FILES['picture']['size'] > 0) {
            
                if ($error = $_FILES['picture']['error'] > 0) {
                    array_push($_SESSION['danger'], "There was a problem with the transfer !");
                }
            
                $maxsize = 5000000;
            
                $picture = $_FILES['picture']['name'];
                $picture_tmp_name = $_FILES['picture']['tmp_name'];
                $picture_size = $_FILES['picture']['size'];
                $upload_folder = "images/";
            
                if ($picture_size >= $maxsize) {
                    array_push($_SESSION['danger'], "File too large !");
                }
            
                $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
            
                if (!in_array($picture_ext_min,$allowed_ext)) {
                    array_push($_SESSION['danger'], "file extension is not allowed !"); 
                }
            }

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                array_push($_SESSION['danger'], "Invalid email !");
            } else {
                
               $userManager = new UserManager();
               $getUserEmail = $userManager->getUserEmail();

                if($getUserEmail) {
                    array_push($_SESSION['danger'], "Email already used !");
                }
            }

            if(empty($_POST['password']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                array_push($_SESSION['danger'], "Invalid password !");
            }

            if(empty($_SESSION['danger'])){
                if(isset($_POST['role']) && $_POST['role'] == 2) {
                    $role = $_POST['role'];
                } else {
                    $role = 1; 
                }

                move_uploaded_file($picture_tmp_name, $upload_folder);
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $userManager = new UserManager();
                $insertUser = $userManager->insertUser($password,$role);

                if ($insertUser == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }

                $_SESSION['adduser'] = 'Creation successfully !';
                
                header('Location: index.php?page=indexuser');

                unset($_SESSION['danger']);
                unset($_SESSION['input']);
            }        

        }

        echo $this->twig->render("backend/users/adduser.html.twig",[
            'activemenu' => 'usermenu'
        ]);
        
    }

    public function edituser()
    {
        $_SESSION['danger'] = array();

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $userManager = new UserManager();
            $editUser = $userManager->editUser($_GET['id']);

            
        } else {
            array_push($_SESSION['danger'], "You need a user id to change it !");       
        }

        if (!empty($_POST) && isset($_POST)) {

            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            $_SESSION['input'] = $_POST;
            
            if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {
                
                array_push($_SESSION['danger'], "Invalid username !");       

            } else {
                    
                $userManager = new UserManager();
                $updateUsername = $userManager->updateUsername($username,$id);
                }

                if($updateUsername == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }

            if(!empty($_FILES['picture']['name'])) {
                
                if ($error = $_FILES['picture']['error'] > 0) {
            
                    array_push($_SESSION['danger'], "There was a problem with the transfer !");
            }
                
            $maxsize = 5000000;
            
            $picture = $_FILES['picture']['name'];
            $picture_tmp_name = $_FILES['picture']['tmp_name'];
            $picture_size = $_FILES['picture']['size'];
            $upload_folder = "images/";

            
            if ($picture_size >= $maxsize) {

                array_push($_SESSION['danger'], "'.$picture.' is too large ( 5 Mo max ) !");
            }
                
            $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
            $picture_ext_min = strtolower($picture_ext);
            $allowed_ext = array('jpg','jpeg','png','gif');
                
            if (!in_array($picture_ext_min,$allowed_ext)) {
                array_push($_SESSION['danger'], "'.$picture.' extension is not allowed ( jpg, jpeg, png and gif only) !");
            }
            
            if(!isset($errors['size']) && !isset($errors['extension'])) {
                $_SESSION['picture'] = $_FILES['picture'];
            }

            if (empty($_SESSION['danger'])) {
                move_uploaded_file($picture_tmp_name, $upload_folder);

                $userManager = new UserManager();
                $updatePicture = $userManager->updatePicture($picture,$id);
                }

                if($updatePicture == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }
        
            }
            
            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

                    $errors['email'] = "Email is not valid !";

            } else {
                    $userManager = new UserManager();
                    $updateEmail = $userManager->updateEmail($email,$id);

                    if($updateEmail == NULL) {
                        array_push($_SESSION['danger'], "There was a problem with a data processing !");
                    }    
                }

            $password = $_POST['password'];

            if(!preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                    $errors['password'] = "Invalid password !";
            } 
            
            if (empty($_SESSION['danger'])) {
                if(isset($_POST['role']) && $_POST['role'] == 2) {
                    $role = $_POST['role'];
                } else {
                    $role = 1; 
                }

                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                $userManager = new UserManager();
                $updatePasswordRole = $userManager->updatePasswordRole($password,$role,$id);

                if($updatePasswordRole == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }  

                $_SESSION['updateuser'] = 'Your update successfully !';

                header('Location: index.php?page=indexuser');  
            }   
        }
                
        echo $this->twig->render("backend/users/edituser.html.twig",[
            'activemenu' => 'usermenu',
            'edituser' => $editUser
            ]);

        unset($_SESSION['input']);
        }      
}