<?php

class frontEndController extends baseController
{
    private $postManager;
    private $tagManager;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new postManager(); 
        $this->tagManager = new tagManager(); 
        $this->commentManager = new commentManager();
    }
    
    public function home()
    {
        $activeMenu = 'homemenu';
        
        $posts = $this->postManager->getPosts();
        $listTags = $this->tagManager->listTags();  
        $comments = $this->commentManager->getComments();

        if (!empty($_POST)) {

            $errors = array();
        
            $_SESSION['input'] = $_POST;
        
            if(!isset($_POST['name']) || $_POST['name'] == "") {
                $errors['name'] = 'Name required !';
            } 
        
            if(!isset($_POST['email']) || $_POST['email'] == "" || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email invalid !';
            }
        
            if(!isset($_POST['message']) || $_POST['message'] == "") {
                $errors['message'] = 'Message is required or invalid !';
            }
        
            if(empty($errors)) {
                $headers = 'FROM: '. $_POST['email'];
                mail('mhathier@gmail.com', 'contact blog de '.$_POST['name'], $_POST['message'], $headers);
        
                $_SESSION['message'] = 'Message sent success !';
            }
        }
        require('view/frontend/home.php');
        unset($errors);
        unset($_SESSION['input']);

        if(isset($_SESSION['message']) && $_SESSION['message'] != "") { ?>   
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['message'] ?>",
                    imageUrl: 'assets/images/letter_red.png',
                    imageWidth: 100,
                    imageHeight: 100,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['message']);
        }

        if(isset($_SESSION['register']) && $_SESSION['register'] != "") { ?>        
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['register'] ?>",
                    text: "Check your inbox for a confirmation email !",
                    imageUrl: 'assets/images/letter_red.png',
                    imageWidth: 100,
                    imageHeight: 100,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['register']);
        } 

        if(isset($_SESSION['confirmation']) && $_SESSION['confirmation'] != "") { ?>        
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['confirmation'] ?>",
                    text: "You are indentified now !",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['confirmation']);
        } 
    }

    public function postsList()
    {
        $activeMenu = 'postsmenu';
        
        $posts = $this->postManager->getPosts();
        $listTags = $this->tagManager->listTags();  
        $comments = $this->commentManager->getComments();
        
        require('view/frontend/postslist.php');
    }

    public function postSingle()
    {
        $activeMenu = 'postsmenu';
        
        $postManager = new postManager();
        $posts = $postManager->getPosts();
        
        $tagManager = new tagManager();
        $listTags = $tagManager->listTags();

        $commentManager = new commentManager();
        $comments = $commentManager->getComments();

        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $postManager = new PostManager();
            $singlePost = $postManager->singlePost($_GET['id']);

            $commentManager = new CommentManager();
            $countCommentsPosts = $commentManager->countCommentsPost($_GET['id']);

            $commentManager = new CommentManager();
            $listComments = $commentManager->listComments($_GET['id']);
        
        } else {
            header('location: ?page=page404');
        }

        if (!empty($_POST)) {

            $errors = array();
        
            if(isset($_POST['submit']) && empty($_POST['name_author'])) {
                $errors['name_author'] = 'Your name is required !';
            }
        
            if(isset($_POST['submit']) && empty($_POST['email_author']) || !filter_var($_POST['email_author'], FILTER_VALIDATE_EMAIL)) {
                $errors['email_author'] = 'Your email is required or invalid !';
            }
        
            if(isset($_POST['submit']) && empty($_POST['comment'])) {
                $errors['comment'] = 'Your comment is required !';
            }
        
            if(empty($errors)) {
        
                $commentManager = new commentManager();
                $insertComment = $commentManager->insertComment();
        
            $_SESSION['comment'] = 'Comment sent successfully !';
            }
        }
        require('view/frontend/postsingle.php');

        if(isset($_SESSION['comment']) && $_SESSION['comment'] != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['comment'] ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        unset($_SESSION['comment']);
        }
    }

    public function userPosts()
    {
        $activeMenu = 'postsmenu';
        
        $posts = $this->postManager->getPosts();
        $listTags = $this->tagManager->listTags();  
        $comments = $this->commentManager->getComments();

        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $userManager = new userManager();
            $getUsername = $userManager->getUsername($_GET['id']);

            $postManager = new postManager();
            $userPosts = $postManager->userPost($_GET['id']);

            if($userPosts === false) {
                header('location: ?page=page404');
            }
        }    
        require('view/frontend/userposts.php');
    }

    public function tagPosts()
    {
        $activeMenu = 'postsmenu';
        
        $posts = $this->postManager->getPosts();
        $listTags = $this->tagManager->listTags();  
        $comments = $this->commentManager->getComments();
        
        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $tagManager = new tagManager();
            $tag = $tagManager->gettag($_GET['id']);

            $postManager = new postManager();
            $tagPosts = $postManager->tagPost($_GET['id']);

            if($tag == false) {
                header('location: ?page=page404');
            }
        } 
        require('view/frontend/tagposts.php');
    }

    public function page404()
    {
        require('view/error/page404.php');
    }

    public function register()
    {
        $activeMenu = 'signupmenu';

        if (!empty($_POST)) {

            $errors = array();
            $_SESSION['input'] = $_POST;
        
            if(empty($_POST['username']) || !preg_match('((?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$)',$_POST['username'])) {
                $errors['username'] = "Invalid username !";
            } else {
                
                $formManager = new formManager();
                $registerUsername = $formManager->registerUsername($_POST['username']);

                if($registerUsername) {
                    $errors['username'] = 'Username already used !';
                } 
            }
        
            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email !";
            } else {
                
                $formManager = new formManager();
                $user = $formManager->registerEmail($_POST['email']);

                if($user) {
                    $errors['email'] = 'Email already used !';
                }
            }
        
            if(empty($_POST['password']) || !preg_match('((?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                $errors['password'] = "Invalid password !";
            }
        
            if(empty($errors)){

                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(60));
                
                $formManager = new formManager();
                $registerUser = $formManager->registerUser($_POST['username'],$_POST['email'],$password,$token);

                if($registerUser != NULL) {
                $to         = $_POST['email'];
                $subject    = 'Confirmation of your account';
                $message    = "In order to validate your registration, please <a href='http://localhost/blogmvc/index.php?page=confirmation&id=$registerUser&token=$token'>click on this link</a>";
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'FROM: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                
                mail($to, $subject, $message, $headers);

                $_SESSION['register'] = "Your registration successful !";
                header('Location: index.php?page=home');
                } else {
                    $errors['process'] = "There was a problem with a data processing !";
                }
            }
        }     
        require('view/frontend/register.php');
        unset($_SESSION['danger']);
        unset($_SESSION['input']);    
    }        
        
    public function confirmation()
    {
        $token = $_GET['token'];

        if(isset($_GET['id']) && isset($_GET['token']) && !empty($_GET['id']) && !empty($_GET['token'])) {

            $formManager = new formManager();
            $tokenUser = $formManager->tokenUser($_GET['id'],$_GET['token']);

            if($tokenUser && $tokenUser['token_confirm'] == $token) {
                
                $formManager = new formManager();
                $tokenConfirm = $formManager->tokenConfirm($_GET['id']);

                if($tokenConfirm == true) {    
                $_SESSION['auth'] = $tokenUser;
                $_SESSION['username'] = $tokenUser['username'];
                $_SESSION['id'] = $tokenUser['id'];
                $_SESSION['picture'] = $tokenUser['picture'];
                $_SESSION['auth_role'] = $tokenUser['role'];
                
                $_SESSION['confirmation'] = "Your account has been validated !";
                header('Location: index.php?page=home');
            } else {
                $_SESSION['process'] = "There was a problem with a data processing !";
                header('Location: index.php?page=login');
            }            
            } else {
                $_SESSION['invalid'] = 'Link is no longer valid !';
                header('Location: index.php?page=login');    
            }
        }
    }

    public function login()
    {
        $activeMenu = 'signinmenu';

        if(isset($_POST) && !empty($_POST)) {  
        
            $formManager = new formManager();
            $user = $formManager->loginUser($_POST['username']);

            if($user != false) {
                if($user['activation'] != 0) {
                    if(password_verify($_POST['password'], $user['password'])) {
                        session_start();
                        $_SESSION['auth'] = $user;
                        $_SESSION['id'] = $user['id'];
                        $_SESSION['username'] = $_POST['username'];
                        $_SESSION['pictures'] = $user['picture'];
                        $_SESSION['auth_role'] = $user['role'];

                        $_SESSION['login'] = 'Welcome to the Dashboard !';
                        header('Location: index.php?page=dashboard');
                    }  else {
                        $errors['danger'] = 'Incorrect username or password';
                    }
                } else { 
                    $danger['activation'] = 'Inactive account !';    
                }
            } else { 
                $errors['danger'] = 'Incorrect username or password';  
            }
        }
    
        require('view/frontend/login.php');

        if(isset($_SESSION['invalid']) && $_SESSION['invalid'] != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $_SESSION['invalid'] ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        unset($_SESSION['invalid']);
        }

        if(isset($_SESSION['process']) && $_SESSION['process'] != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $_SESSION['process'] ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        unset($_SESSION['process']);
        }

        if(isset($danger['activation']) && $danger['activation'] != "") { ?>        
            <script>
                Swal.fire({
                title: "<?= $danger['activation'] ?>",
                text: "Please follow instructions sent by email !",
                icon: "error",
                confirmButtonColor: '#1aBC9C',
                });
            </script>
        <?php
            unset($danger['activation']);
            } 

        if(isset($_SESSION['reset']) && $_SESSION['reset'] != "") { ?>
            <script>
                Swal.fire({
                title: "<?= $_SESSION['reset'] ?>",
                text: "Login please !",
                icon: "success",
                confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            unset($_SESSION['forget']);
            }

        if(isset($_SESSION['logout']) && $_SESSION['logout'] != "") { ?>        
            <script>
                Swal.fire({
                    title: "<?= $_SESSION['logout'] ?>",
                    imageUrl: 'assets/images/avatar.png',
                    imageWidth: 200,
                    imageHeight: 200,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $_SESSION = array();
        session_destroy();
        }         
    }

    public function logout()
    {
        $_SESSION['logout'] = 'Thank you for your visit !';
        header('Location: index.php?page=login');
    }

    public function forget()
    {
        if(!empty($_POST)) {

            $email = $_POST['email'];
        
            $formManager = new formManager();
            $forgetUser = $formManager->forgetUser($email);

            if($forgetUser) {
                $forget_token = bin2hex(random_bytes(60));
        
                $formManager = new formManager();
                $updateForget = $formManager->updateForget($forget_token,$forgetUser);

                if($updateForget == NULL) {
                    $errors['danger'] = "There was a problem with a data processing !";
                }

                $user_id = $forgetUser['id'];

                $to         = $_POST['email'];
                $subject    = 'Resetting your password';
                $message    = "To reset your password, please <a href='http://localhost/blogmvc/index.php?page=reset&id=$user_id&token=$forget_token'>click on this link</a>";
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'From: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                
                mail($to, $subject, $message, $headers);
        
                $_SESSION['forget'] = 'Check your inbox to reset password !';    
            }  else {
                $errors['danger'] = "No account corresponds to this email address !";        
            }    
        }     
        require('view/frontend/forget.php');

        if(isset($_SESSION['forget']) && $_SESSION['forget'] != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $_SESSION['forget'] ?>",
                imageUrl: 'assets/images/letter_red.png',
                imageWidth: 100,
                imageHeight: 100,
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        unset($_SESSION['forget']);
        }
    }

    public function reset()
    {
        if(isset($_GET['id']) && isset($_GET['token'])) {

            $formManager = new formManager();
            $resetUser = $formManager->resetUser();
        
            if($resetUser) {
                if(!empty($_POST)) {

                    if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        $formManager = new formManager();
                        $updateReset = $formManager->UpdateReset($password,$resetUser);

                        if($updateReset == NULL) {
                            $errors['danger'] = "There was a problem with a data processing !";
                        }
                        $_SESSION['auth'] = $resetUser;
                        $_SESSION['id'] = $resetUser['id'];
                        $_SESSION['username'] = $resetUser['username'];
                        $_SESSION['pictures'] = $resetUser['picture'];
                        $_SESSION['auth_role'] = $resetUser['role'];
        
                        $_SESSION['reset'] = 'Well done, your password has been reset !';
                        header('Location: index.php?page=login');                     
                    } else {
                        $errors['danger'] = "Password invalid !";
                    }
                } 
            } else {
                $_SESSION['invalid'] = 'Link is no longer valid !';
                header('Location: index.php?page=login');
            }
        } else {
            header('Location: index.php?page=login');  
        }  
        require('view/frontend/reset.php');
    }
}