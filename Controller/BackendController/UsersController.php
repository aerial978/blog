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

        if(isset($_SESSION['edituser']) && $_SESSION['edituser'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['edituser'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['edituser']);
        }

        if(isset($_SESSION['adduser']) && $_SESSION['adduser'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['adduser'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['adduser']);
        }
    }

    public function adduser()
    {
        $_SESSION['danger'] = array();

        $_SESSION['input'] = $_POST;

        if (!empty($_POST)) {

            if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {

                $_SESSION['danger']['username'] = "Invalid username !";

            } else {
                
                $userManager = new UserManager();
                $getUserId = $userManager->getUserId();

                if($getUserId) {
                    $_SESSION['danger']['username_used'] = "Username already used !";
                } 
            }

            if(isset($_FILES['picture']) && $_FILES['picture']['size'] == 0) {
                $_SESSION['danger']['picture'] = "Select an image !";
            
            } else if (isset($_FILES['picture']) && $_FILES['picture']['size'] > 0) {
            
                if ($_FILES['picture']['error'] > 0) {
                    $_SESSION['danger']['transfer'] = "There was a problem with the transfer !";
                }
            
                $maxsize = 1000000;
            
                $picture = $_FILES['picture']['name'];
                $picture_tmp_name = $_FILES['picture']['tmp_name'];
                $picture_size = $_FILES['picture']['size'];
                $upload_folder = "images/";
            
                if ($picture_size >= $maxsize) {
                    $_SESSION['danger']['size'] = "$picture is too large ( 1 Mo max ) !";
                }
            
                $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg','jpeg','png','gif');
            
                if (!in_array($picture_ext_min,$allowed_ext)) {
                    $_SESSION['danger']['extension'] = "$picture : extension is not allowed ( jpg, jpeg, png and gif only ) !"; 
                }
            }

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $_SESSION['danger']['email'] = "Invalid email !";
            } else {
                
               $userManager = new UserManager();
               $getUserEmail = $userManager->getUserEmail();

                if($getUserEmail) {
                    $_SESSION['danger']['email_used'] = "Email already used !";
                }
            }

            if(empty($_POST['password']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                $_SESSION['danger']['password'] = "Invalid password !";
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
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }

                $_SESSION['adduser'] = 'Creation successfully !';
                
                header('Location: index.php?page=indexuser');

            }        

        }

        echo $this->twig->render("backend/users/adduser.html.twig",[
            'activemenu' => 'usermenu'
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

    public function edituser()
    {
        $_SESSION['danger'] = array();

        if(isset($_GET['id'])) {

            $id = $_GET['id'];

            $userManager = new UserManager();
            $editUser = $userManager->editUser($_GET['id']);

            
        } else {
            $_SESSION['danger']['id'] = "You need a user id to change it !";       
        }

        if (!empty($_POST) && isset($_POST)) {

            /*$username = $_POST['username'];*/
            $email = $_POST['email'];
            $password = $_POST['password'];

            $_SESSION['input'] = $_POST;
            
            /*if(empty($_POST['username']) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['username'])) {
                
                $_SESSION['danger']['username'] = "Invalid username !";       

            } else {
                    
                $userManager = new UserManager();
                $updateUsername = $userManager->updateUsername($username,$id);
                }

                if($updateUsername == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }*/

            if(!empty($_FILES['picture']['name'])) {
                
                if ($_FILES['picture']['error'] > 0) {
            
                    $_SESSION['danger']['transfer'] = "There was a problem with the transfer !";
            }
                
            $maxsize = 5000000;
            
            $picture = $_FILES['picture']['name'];
            $picture_tmp_name = $_FILES['picture']['tmp_name'];
            $picture_size = $_FILES['picture']['size'];
            $upload_folder = "images/";

            
            if ($picture_size >= $maxsize) {

                $_SESSION['danger']['size'] = "$picture is too large ( 5 Mo max ) !";
            }
                
            $picture_ext = pathinfo($picture,PATHINFO_EXTENSION);
            $picture_ext_min = strtolower($picture_ext);
            $allowed_ext = array('jpg','jpeg','png','gif');
                
            if (!in_array($picture_ext_min,$allowed_ext)) {
                $_SESSION['danger']['extension'] = "$picture : extension is not allowed ( jpg, jpeg, png and gif only) !";
            }
            
            if(!isset($_SESSION['danger']['size']) && !isset($_SESSION['danger']['extension'])) {
                $_SESSION['picture'] = $_FILES['picture'];
            }

            if (empty($_SESSION['danger'])) {
                move_uploaded_file($picture_tmp_name, $upload_folder);

                $userManager = new UserManager();
                $updatePicture = $userManager->updatePicture($picture,$id);
                }

                if($updatePicture == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }
        
            }
            
            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

                $_SESSION['danger']['email'] = "Invalid Email !";

            } else {
                    $userManager = new UserManager();
                    $updateEmail = $userManager->updateEmail($email,$id);

                    if($updateEmail == NULL) {
                        $_SESSION['danger']['process'] =  "There was a problem with a data processing !";
                    }    
                }

            $password = $_POST['password'];

            if(!preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                    $_SESSION['danger']['password'] = "Invalid password !";
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
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                } 
                
                $_SESSION['edituser'] = 'Update successfully !';
        
                header('Location: index.php?page=indexuser');  
                
            }   
        } 
                
        echo $this->twig->render("backend/users/edituser.html.twig",[
        'activemenu' => 'usermenu',
        'edituser' => $editUser
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

    public function deleteuser()
    {
        $id = $_GET['id'];

        $userManager = new UserManager();
        $deleteUser = $userManager->deleteUser($id);

        if($deleteUser == NULL) {
            $_SESSION['danger'] = "There was a problem with a data processing !";
        }

        header('Location: index.php?page=indexuser');
    }
}