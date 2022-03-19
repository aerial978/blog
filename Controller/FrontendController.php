<?php

require_once 'BaseController.php';
require_once 'model/FormManager.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';
require_once 'model/CommentManager.php';
require_once 'model/UserManager.php';


class FrontendController extends BaseController {

    public function home()
    {
        if (!empty($_POST)) {

            $_SESSION['danger'] = array();
        
            $_SESSION['input'] = $_POST;
        
            if(!isset($_POST['name']) || $_POST['name'] == "") {
        
                array_push($_SESSION['danger'], "Name required !");
            } 
        
            if(!isset($_POST['email']) || $_POST['email'] == "" || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        
                array_push($_SESSION['danger'], "Email invalid !");
            }
        
            if(!isset($_POST['message']) || $_POST['message'] == "") {
        
                array_push($_SESSION['danger'], "Message is required or invalid !");
            }
        
            if(empty($_SESSION['danger'])) {
                $headers = 'FROM: '. $_POST['email'];
                mail('mhathier@gmail.com', 'Mon blog, contact de '.$_POST['name'], $_POST['message'], $headers);
        
                $_SESSION['message'] = 'Message sent successfully !';
        
            }   
        }

        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu'
        ]);

        if(isset($_SESSION['success']) && $_SESSION['success'] != "") { ?>
            <script>
                swal({
                title: "<?= $_SESSION['success'] ?>",
                text: "Check your inbox for a confirmation email",
                icon: "success", 
                }).then(function() {
                window.location = "index.php?page=home";
                });
            </script>
        <?php
            unset($_SESSION['success']);
            }

        if(isset($_SESSION['confirmation']) && $_SESSION['confirmation'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['confirmation'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['confirmation']);
            } 

        if(isset($_SESSION['message']) && $_SESSION['message'] != "") { ?>
        
            <script>
                swal({
                title: "<?= $_SESSION['message'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['input']);
            unset($_SESSION['danger']);
            unset($_SESSION['message']); 
            }
    }

    public function postslist()
    {
        echo $this->twig->render("frontend/postslist.html.twig",[
            'activemenu' => 'postslistmenu'
        ]);
    }

    public function postsingle()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $postManager = new PostManager();
            $post = $postManager->singlePost($_GET['id']);

            $commentManager = new CommentManager();
            $listcomments = $commentManager->listComments($_GET['id']);

            if($post == NULL) {
                header('location: ?page=page404');
            }

            $commentManager = new CommentManager();
            $countcommentsPosts = $commentManager->countCommentsPost($_GET['id']);

            if (!empty($_POST)) {

                $_SESSION['danger'] = array();
            
                if(isset($_POST['submit']) && empty($_POST['name_author'])) {
            
                    $_SESSION['danger']['author'] = 'Your name is required !';
                }
            
                if(isset($_POST['submit']) && empty($_POST['email_author']) || !filter_var($_POST['email_author'], FILTER_VALIDATE_EMAIL)) {
            
                    $_SESSION['danger']['email'] = 'Your email is required or invalid !';
                }
            
                if(isset($_POST['submit']) && empty($_POST['comment'])) {
            
                    $_SESSION['danger']['comment'] = 'Your comment is required !';
                }
            
                if(empty($_SESSION['danger'])) {
            
                $commentManager = new CommentManager();
                $insertComment = $commentManager->insertComment();

                if($insertComment == NULL) {
                    $_SESSION['danger']['process'] = "There was a problem with a data processing !";
                }
            
                $_SESSION['successcomment'] = 'Comment sent successfully !';
            
                }
            }
            
            echo $this->twig->render("frontend/postsingle.html.twig",[
                'activemenu' => 'postslistmenu',
                'post' => $post,
                'listcomments' => $listcomments,
                'countcommentsPosts' => $countcommentsPosts
            ]);

        } else {
            header('location: ?page=page404');
        }

        if(isset($_SESSION['successcomment']) && $_SESSION['successcomment'] != "") { ?>
            <script>
                swal({
                title: "<?= $_SESSION['successcomment'] ?>",
                text: "",
                icon: "success", 
                });
            </script>
        <?php
            unset($_SESSION['successcomment']);
            } 
    }

    public function userposts()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $userManager = new UserManager();
            $getUsername = $userManager->getUsername($_GET['id']);

            $postManager = new PostManager();
            $userposts = $postManager->userPost($_GET['id']);

            if($userposts == NULL) {
                header('location: ?page=page404');
            }

            echo $this->twig->render("frontend/userposts.html.twig",[
                'activemenu' => 'postslistmenu',
                'user' => $getUsername,
                'userposts' => $userposts    
            ]);

        } else {
            header('location: ?page=page404');
        }
    }

    public function tagposts()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $tagManager = new TagManager();
            $tag = $tagManager->gettag($_GET['id']);

            $postManager = new PostManager();
            $tagposts = $postManager->tagPost($_GET['id']);

            if($tag == NULL) {
                header('location: ?page=page404');
            }

        echo $this->twig->render("frontend/tagposts.html.twig",[
            'activemenu' => 'postslistmenu',
            'tag' => $tag,
            'tagposts' => $tagposts
        ]);

        } else {
            header('location: ?page=page404');
        }
    }

    public function page404(){
        echo $this->twig->render("frontend/error/page404.html.twig");
    }


    public function register()
    {
        if (!empty($_POST)) {

            $_SESSION['danger'] = array();
        
            $_SESSION['input'] = $_POST;
        
            if(empty($_POST['username']) || !preg_match('((?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$)',$_POST['username'])) {
                array_push($_SESSION['danger'],"Username is not valid !");
                header('Location: index.php?page=register');

            } else {

                $formManager = new FormManager();
                $user = $formManager->registerUsername($_POST['username']);

                if($user) {
                    array_push($_SESSION['danger'],'Username already used !');
                    header('Location: index.php?page=register');
                } 
            }

            if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                array_push($_SESSION['danger'],"Your email is not valid !");
                header('Location: index.php?page=register');

            } else {

                $formManager = new FormManager();
                $user = $formManager->registerEmail($_POST['email']);

                if($user) {
                    array_push($_SESSION['danger'],'Email already used !');
                    header('Location: index.php?page=register');
                }
            }

            if(empty($_POST['password']) || !preg_match('((?=^.{8,255}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$)',$_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
                array_push($_SESSION['danger'],'Invalid password !');
                header('Location: index.php?page=register');
            }

            if(empty($_SESSION['danger'])){

                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(60));

                $formManager = new FormManager();
                $registerUser = $formManager->registerUser($_POST['username'],$_POST['email'],$password,$token);

                if($registerUser != NULL) {

                    $to         = $_POST['email'];
                    $subject    = 'Confirmation of your account';
                    $message    = "In order to validate your registration, please <a href='http://localhost/blog/index.php?page=confirmation&id=$registerUser&token=$token'>click on this link</a>";
                    $headers    = 'MIME Version 1.0\r\n';
                    $headers    = 'FROM: Your name <info@address.com>' . "\r\n";
                    $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                    
                    mail($to, $subject, $message, $headers);

                    $_SESSION['success'] = "Your registration successful !";
                    header('Location: index.php?page=home');

                } else {
                    array_push($_SESSION['danger'],'Probleme !');
                }
            }

        } else {
            
            unset($_SESSION['danger']);
            echo $this->twig->render("frontend/register.html.twig",[
                'activemenu' => 'signupmenu' 
            ]);

            unset($_SESSION['input']);
        }        
    }

    public function confirmation()
    {
        $token = $_GET['token'];

        if(isset($_GET['id']) && isset($_GET['token']) && !empty($_GET['id']) && !empty($_GET['token'])) {

            $userManager = new UserManager();
            $tokenUser = $userManager->tokenUser($_GET['id'],$_GET['token']);

            if($tokenUser && $tokenUser['token_confirm'] == $token) {

                $userManager = new UserManager();
                $tokenConfirm = $userManager->tokenConfirm($_GET['id']);

                if($tokenConfirm == true) {
                
                    $_SESSION['auth'] = $tokenUser;
                    $_SESSION['username'] = $tokenUser['username'];
                    $_SESSION['id'] = $tokenUser['id'];
                    $_SESSION['picture'] = $tokenUser['picture'];
                    $_SESSION['auth_role'] = $tokenUser['role'];
                    
                    $_SESSION['confirmation'] = "Your account has been validated !";
                    header('Location: index.php?page=home');

                } else {
                    $_SESSION['danger'] = "There was a problem with a data processing !";
                }
                    
            } else {

                $_SESSION['danger'] = 'Link is no longer valid !';
                header('Location: index.php?page=login');            
            }
        }
    }

    public function login()
    {
        if(isset($_POST) && !empty($_POST)) {  

            $formManager = new FormManager();
            $user = $formManager->loginUser($_POST['username']);
            
            if($user != false) {
                if(password_verify($_POST['password'], $user['password'])) {
                $_SESSION['auth'] = $user;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['pictures'] = $user['picture'];
                $_SESSION['auth_role'] = $user['role'];
                $_SESSION['login'] = 'Welcome to the Dashboard !';

                header('Location: index.php?page=dashboard');
                exit();

                } else {
                    $_SESSION['danger'] = 'Incorrect username or password';
                    header('Location: index.php?page=login');
                }
            } else { 
                $_SESSION['danger'] = 'Incorrect username or password';
                header('Location: index.php?page=login');
            }     
        } else {

            unset($_SESSION['danger']);
            echo $this->twig->render("frontend/login.html.twig",[
                'activemenu' => 'signinmenu' 
            ]);  
            
            if(isset($_SESSION['successforget']) && $_SESSION['successforget'] != "") { ?>
            
                <script>
                    swal({
                    title: "<?= $_SESSION['successforget'] ?>",
                    text: "",
                    icon: "success", 
                    });
                </script>
            <?php
                unset($_SESSION['successforget']);
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
    }

    public function logout() 
    {   

        $_SESSION['logout'] = 'See you soon !';

        header('Location: index.php?page=login');

    }

    public function forget()
    {
        $_SESSION['danger'] = array();

        if(!empty($_POST)) {

            $email = $_POST['email'];
        
            $formManager = new FormManager();
            $forgetUser = $formManager->forgetUser($email);

            if($forgetUser) {
        
                $forget_token = bin2hex(random_bytes(60));
        
                $formManager = new FormManager();
                $updateForget = $formManager->updateForget($forget_token,$forgetUser);

                if($updateForget == NULL) {
                    array_push($_SESSION['danger'], "There was a problem with a data processing !");
                }
        
                $user_id = $forgetUser['id'];
        
                $to         = $_POST['email'];
                $subject    = 'Resetting your password';
                $message    = "To reset your password, please <a href='http://localhost/blog/index.php?page=reset&id=$user_id&token=$forget_token'>click on this link</a>";
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'From: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                
                mail($to, $subject, $message, $headers);
        
                $_SESSION['successforget'] = 'Check your inbox to reset password !';
                header('Location: index.php?page=login');
        
            }  else 
                 {
                array_push($_SESSION['danger'], "No account corresponds to this email address !");        
            }    
        } 

        echo $this->twig->render("frontend/forget.html.twig");
    }

    public function reset()
    { 
        if(isset($_GET['id']) && isset($_GET['token'])) {

            $formManager = new FormManager();
            $resetUser = $formManager->resetUser();
        
            if($resetUser) {

                if(!empty($_POST)) {

                    $_SESSION['danger'] = array();

                    if(!empty($_POST['password']) && $_POST['password'] == $_POST['password_confirm']) {
                        
                        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                        $formManager = new FormManager();
                        $updateReset = $formManager->UpdateReset($password,$resetUser);

                        if($updateReset == NULL) {
                            array_push($_SESSION['danger'], "There was a problem with a data processing !");
                        }

                        $_SESSION['auth'] = $resetUser;
                        $_SESSION['id'] = $resetUser['id'];
                        $_SESSION['username'] = $resetUser['username'];
                        $_SESSION['pictures'] = $resetUser['picture'];
                        $_SESSION['auth_role'] = $resetUser['role'];
        
                        $_SESSION['successreset'] = 'Well done, your password has been reset !';
                        header('Location: index.php?page=dashboard');
                        
                    } else {
                        
                        array_push($_SESSION['danger'], "Password invalid !");
                    }
                } 
            } else {
        
                $_SESSION['erroreset'] = 'Link is no longer valid !';
                header('Location: index.php?page=login');
            }
        
        } else {
        
            header('Location: index.php?page=login');
            exit();  
        }

        echo $this->twig->render("frontend/reset.html.twig");

    }
        
  
};