<?php

require_once 'model/userManager.php';

class usersController
{
    public function indexUser()
    {
        $activeMenu = 'usermenu';

        if(isset($_SESSION['auth_role']) && $_SESSION['auth_role'] == 1) {

            $userManager = new userManager();
            $indexUsers = $userManager->indexUser1();

            } else {
            
                $userManager = new userManager();
                $indexUsers = $userManager->indexUser2();
            }
        
        require('view/backend/users/indexuser.php');

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

    public function addUser()
    {
        $activeMenu = 'usermenu';

        $errors = array();

        $_SESSION['input'] = $_POST;

        if (!empty($_POST)) {

            if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {

                $errors['username'] = "Invalid username !";

            } else {
                
                $userManager = new UserManager();
                $getUserId = $userManager->getUserId();

                if($getUserId) {
                    $errors['username'] = 'Username already used !';
                } 
            }

            if(isset($_FILES['picture']) && $_FILES['picture']['size'] == 0) {
                $errors['picture'] = 'Select an image !';
            
            } else if (isset($_FILES['picture']) && $_FILES['picture']['size'] > 0) {
            
                if ($_FILES['picture']['error'] > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }
            
                $maxsize = 5000000;
            
                $picture = $_FILES['picture']['name'];
                $picture_tmp_name = $_FILES['picture']['tmp_name'];
                $picture_size = $_FILES['picture']['size'];
                $upload_folder = "images/";
            
                if ($picture_size >= $maxsize) {
                    $errors['size'] = 'File too large !';
                }
            
                $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
            
                if (!in_array($picture_ext_min,$allowed_ext)) {
                    $errors['extension'] = 'file extension is not allowed !'; 
                }
            }

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email !";
            } else {
                
                $userManager = new UserManager();
                $getUserEmail = $userManager->getUserEmail();
                
                if($getUserEmail) {
                    $errors['email'] = 'Email already used !';
                }
            }

            if(empty($_POST['password']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                $errors['password'] = "Invalid password !";
            }

            $_SESSION['errors'] = $errors;

            if(empty($errors)){
                if(isset($_POST['role']) && $_POST['role'] == 2) {
                    $role = $_POST['role'];
                } else {
                    $role = 1; 
                }

                move_uploaded_file($picture_tmp_name, $upload_folder); 
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT); 

                $userManager = new UserManager();
                $insertUser = $userManager->insertUser($password,$role);
                
                $_SESSION['create'] = 'Creation successfully !';    
                header('Location: index.php?page=indexuser');
            }        
        }           
        require('view/backend/users/adduser.php');
        unset($_SESSION['errors']);
        unset($_SESSION['input']);
    }

    public function editUser()
    {
        $activeMenu = 'usermenu';

        $errors = array();

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $userManager = new UserManager();
            $editUser = $userManager->editUser($_GET['id']);

            } else {

            $errors['id'] = 'You need a user id to change it !';
            }

            if (!empty($_POST) && isset($_POST)) {

                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $_SESSION['input'] = $_POST;

                if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {

                $errors['username'] = "Username is not valid !";

                } else {
                    $userManager = new userManager();
                    $updateUsername = $userManager->updateUsername($username,$id);
                }

                if(!empty($_FILES['picture']['name'])) {

                if ($error = $_FILES['picture']['error'] > 0) {

                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $maxsize = 5000000;

                $picture = $_FILES['picture']['name'];
                $picture_tmp_name = $_FILES['picture']['tmp_name'];
                $picture_size = $_FILES['picture']['size'];
                $upload_folder = "images/";


                if ($picture_size >= $maxsize) {
                $errors['size'] = ''.$picture.' is too large ( 5 Mo max ) !';
                }

                $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
                    
                if (!in_array($picture_ext_min,$allowed_ext)) {
                $errors['extension'] = ''.$picture.' extension is not allowed ( jpg, jpeg, png and gif only) !';
                }

                if(!isset($errors['size']) && !isset($errors['extension'])) {
                $_SESSION['picture'] = $_FILES['picture'];
                }

                if (empty($errors)) {
                move_uploaded_file($picture_tmp_name, $upload_folder);
                
                    $userManager = new userManager();
                    $updatePicture = $userManager->updatePicture($picture,$id);
                }
            }

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

                $errors['email'] = "Invalid Email !";

            } else {    
                $userManager = new UserManager();
                $updateEmail = $userManager->updateEmail($email,$id);
            }

            $password = $_POST['password'];

            if(!preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                $errors['password'] = "Invalid password !";
            } 

            $_SESSION['errors'] = $errors;

            if (empty($errors)) {

                if(isset($_POST['role']) && $_POST['role'] == 2) {
                $role = $_POST['role'];
            } else {
                $role = 1; 
            }

            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $userManager = new userManager();
            $updatePasswordRole = $userManager->updatePasswordRole($password,$role,$id);

            $_SESSION['update'] = 'Update successfully !';
            header('Location: index.php?page=indexuser');  
            }   
        }
        require('view/backend/users/edituser.php');
        unset($_SESSION['errors']);
        unset($_SESSION['input']);
    }

    public function deleteuser()
    {
        $userManager = new UserManager();
        $deleteUser = $userManager->deleteUser($_GET['id']);

        if($deleteUser == NULL) {
            $_SESSION['danger'] = "There was a problem with a data processing !";
        }
        header('Location: index.php?page=indexuser');
    }   
}