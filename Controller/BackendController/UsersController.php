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
    }

    public function adduser()
    {
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
                
                array_push($_SESSION['danger'], "Username is not valid !");       

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

                unset($_SESSION['danger']);
                unset($_SESSION['input']);

                header('Location: index.php?page=indexuser');  
            }   
        }
                
        echo $this->twig->render("backend/users/edituser.html.twig",[
            'activemenu' => 'usermenu',
            'edituser' => $editUser
            ]);
        } 
}