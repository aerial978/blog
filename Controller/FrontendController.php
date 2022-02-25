<?php

require_once 'BaseController.php';
require_once 'model/FormManager.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';
require_once 'model/CommentManager.php';
require_once 'model/UserManager.php';


class FrontendController extends BaseController{

    public function home()
    {
        echo $this->twig->render("frontend/home.html.twig",[
            'activemenu' => 'homemenu'
        ]);
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
            $countcomments = $commentManager->countComments();  /* off */

            echo $this->twig->render("frontend/postsingle.html.twig",[
                'activemenu' => 'postslistmenu',
                'post' => $post,
                'listcomments' => $listcomments
                /* 'countcomments' => $countcomments*/
            ]);

        } else {
            header('location: ?page=page404');
        }
    }

    public function userposts()
    {
        if(isset($_GET['id']) && !empty($_GET['id'])) {

            $userManager = new UserManager();
            $user = $userManager->getUser($_GET['id']);

            $postManager = new PostManager();
            $userposts = $postManager->userPost($_GET['id']);

            if($userposts == NULL) {
                header('location: ?page=page404');
            }

            echo $this->twig->render("frontend/userposts.html.twig",[
                'activemenu' => 'postslistmenu',
                'user' => $user,
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
            $tag = $tagManager->getTag($_GET['id']);

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

                $formManager = new FormManager();
                $formManager->registerUser($_POST['username'],$_POST['email']);

                $_SESSION['success'] = "Your registration successful !";
            }

        } else {

            unset($_SESSION['danger']);
            echo $this->twig->render("frontend/register.html.twig",[
                'activemenu' => 'signupmenu' 
            ]);

        }

    }

    public function confirmation()
    {
        $user_id = $_GET['id'];

        $token = $_GET['token'];

        if(isset($_GET['id']) && isset($_GET['token'])) {

            $userManager = new UserManager();
            $tokenUser = $userManager->tokenUser($_GET['id'],$_GET['token']);

            if($tokenUser && $tokenUser['token_confirm'] == $token) {
                
                $_SESSION['auth'] = $tokenUser;
                $_SESSION['username'] = $tokenUser['username'];
                $_SESSION['id'] = $tokenUser['id'];
                $_SESSION['picture'] = $tokenUser['picture'];
                $_SESSION['auth_role'] = $tokenUser['role'];
                
                $_SESSION['successreg'] = "Your account has been validated !";
                header('Location: index.php');
                
                
            } else {

                $_SESSION['erroreg'] = 'Link is no longer valid !';
                header('Location: login.php');
                
            }

        }

        echo $this->twig->render("frontend/confirmation.html.twig",[
            
        ]);
    }

    public function login()
    {
        if(!empty($_POST)) {  

            $formManager = new FormManager();
            $user = $formManager->loginUser($_POST['username']);
            
            if($user != false) {
                if(password_verify($_POST['password'], $user['password'])) {
                $_SESSION['auth'] = $user;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['pictures'] = $user['picture'];
                $_SESSION['auth_role'] = $user['role'];
                $_SESSION['successlogin'] = 'Welcome to the Dashboard !';

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
        }
  
    }

    public function logout()
    
    {   
        session_destroy();

        $_SESSION['logout'] = 'See you soon !';

        header('Location: index.php?page=login');

    }

    public function forget()
    {
        echo $this->twig->render("frontend/forget.html.twig");
    }

    public function reset()
    {
        echo $this->twig->render("frontend/reset.html.twig");
    }
  
};