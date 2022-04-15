<?php

session_start();

spl_autoload_register(function($class){
    $parts = explode('\\', $class);
    if(file_exists('controller/' . end($parts) . '.php'))
    {
        require_once('controller/' . end($parts) . '.php');

    }
    if(file_exists('model/' . end($parts) . '.php'))
    {
        $parts = explode('\\', $class);

        require_once('model/' . end($parts) . '.php');
    }

   
});

$_GET["page"] == "home";

switch ($_GET["page"]) {

    case 'home':
        $homeController = new frontEndController();
        $homeController->home();
        break;

    case 'postslist':
        require "controller/frontEndController.php";
        $postslistController = new frontEndController();
        $postslistController->postsList();
        break;
    
    case 'postsingle':
        require "controller/frontEndController.php";
        $postsingleController = new frontEndController();
        $postsingleController->postSingle();
        break;

    case 'userposts':
        require "controller/frontEndController.php";
        $userpostsController = new frontEndController();
        $userpostsController->userPosts();
        break;

    case 'tagposts':
        require "controller/frontEndController.php";
        $tagpostsController = new frontEndController();
        $tagpostsController->tagPosts();
        break;

    case 'register':
        require "controller/frontEndController.php";
        $registerController = new frontEndController();
        $registerController->register();
        break;

    case 'confirmation':
        require "controller/frontEndController.php";
        $confirmationController = new frontEndController();
        $confirmationController->confirmation();
        break;
    
    case 'login':
        require "controller/frontEndController.php";
        $loginController = new frontEndController();
        $loginController->login();
        break;

    case 'logout':
        require "controller/frontEndController.php";
        $logoutController = new frontEndController();
        $logoutController->logout();
        break;

    case 'forget':
        require "controller/frontEndController.php";
        $forgetController = new frontEndController();
        $forgetController->forget();
        break;

    case 'reset':
        require "controller/frontEndController.php";
        $resetController = new frontEndController();
        $resetController->reset();
        break;
    
    case 'dashboard':
        require "controller/backEndController/dashboardController.php";
        $dashboardController = new dashboardController();
        $dashboardController->dashboard();
        break;

    case 'indexpost':
        require "controller/backEndController/postsController.php";
        $indexpostController = new postsController();
        $indexpostController->indexPost();
        break;

    case 'addpost':
        require "controller/backEndController/postsController.php";
        $addpostController = new postsController();
        $addpostController->addPost();
        break;

    case 'editpost':
        require "controller/backEndController/postsController.php";
        $editpostController = new postsController();
        $editpostController->editPost();
        break;

    case 'deletepost':
        require "controller/backEndController/postsController.php";
        $deletepostController = new postsController();
        $deletepostController->deletePost();
        break;

    case 'indexcomment':
        require "controller/backEndController/commentsController.php";
        $indexcommentController = new commentsController();
        $indexcommentController->indexComment();
        break;

    case 'editcomment':
        require "controller/backEndController/commentsController.php";
        $editcommentController = new commentsController();
        $editcommentController->editComment();
        break;

    case 'deletecomment':
        require "controller/backEndController/commentsController.php";
        $deleteCommentController = new commentsController();
        $deleteCommentController->deleteComment();
        break;

    case 'indexuser':
        require "controller/backEndController/UsersController.php";
        $indexuserController = new usersController();
        $indexuserController->indexUser();
        break;

    case 'adduser':
        require "controller/backEndController/usersController.php";
        $adduserController = new usersController();
        $adduserController->addUser();
        break;

    case 'edituser':
        require "controller/backEndController/usersController.php";
        $edituserController = new usersController();
        $edituserController->editUser();
        break;

    case 'deleteuser':
        require "controller/backEndController/usersController.php";
        $deleteUserController = new usersController();
        $deleteUserController->deleteUser();
        break;

    case 'indextag':
        require "controller/backEndController/tagsController.php";
        $indextagController = new tagsController();
        $indextagController->indextag();
        break;

    case 'addtag':
        require "controller/backEndController/tagsController.php";
        $addtagController = new tagsController();
        $addtagController->addTag();
        break;

    case 'edittag':
        require "controller/backEndController/tagsController.php";
        $edittagController = new tagsController();
        $edittagController->editTag();
        break;

    case 'deletetag':
        require "controller/backEndController/tagsController.php";
        $deleteTagController = new tagsController();
        $deleteTagController->deletetag();
        break;
    
    default:
        require "controller/frontEndController.php";
        $page404Controller = new frontEndController();
        $page404Controller->page404();
        break;          
}

?>