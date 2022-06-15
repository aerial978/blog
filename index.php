<?php

session_start();

spl_autoload_register(function($class){
    $parts = explode('\\', $class);
    if(file_exists('controller/' . end($parts) . '.php'))
    {
        require_once('controller/' . end($parts) . '.php');
    }
    if(file_exists('controller/backEndController/' . end($parts) . '.php'))
    {
        require_once('controller/backEndController/' . end($parts) . '.php');
    }
    if(file_exists('model/' . end($parts) . '.php'))
    {
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
        $postslistController = new frontEndController();
        $postslistController->postsList();
        break;
    
    case 'postsingle':
        $postsingleController = new frontEndController();
        $postsingleController->postSingle();
        break;

    case 'userposts':
        $userpostsController = new frontEndController();
        $userpostsController->userPosts();
        break;

    case 'tagposts':
        $tagpostsController = new frontEndController();
        $tagpostsController->tagPosts();
        break;

    case 'register':
        $registerController = new registerController();
        $registerController->register();
        break;

    case 'confirmation':
        $confirmationController = new registerController();
        $confirmationController->confirmation();
        break;
    
    case 'login':
        $loginController = new loginController();
        $loginController->login();
        break;

    case 'logout':
        $logoutController = new logoutController();
        $logoutController->logout();
        break;

    case 'forget':
        $forgetController = new loginController();
        $forgetController->forget();
        break;

    case 'reset':
        $resetController = new loginController();
        $resetController->reset();
        break;
    
    case 'dashboard':
        $dashboardController = new dashboardController();
        $dashboardController->dashboard();
        break;

    case 'indexpost':
        $indexpostController = new postsController();
        $indexpostController->indexPost();
        break;

    case 'addpost':
        $addpostController = new postsController();
        $addpostController->addPost();
        break;

    case 'editpost':
        $editpostController = new postsController();
        $editpostController->editPost();
        break;

    case 'deletepost':
        $deletepostController = new postsController();
        $deletepostController->deletePost();
        break;

    case 'indexcomment':
        $indexcommentController = new commentsController();
        $indexcommentController->indexComment();
        break;

    case 'editcomment':
        $editcommentController = new commentsController();
        $editcommentController->editComment();
        break;

    case 'deletecomment':
        $deleteCommentController = new commentsController();
        $deleteCommentController->deleteComment();
        break;

    case 'indexuser':
        $indexuserController = new usersController();
        $indexuserController->indexUser();
        break;

    case 'adduser':
        $adduserController = new usersController();
        $adduserController->addUser();
        break;

    case 'edituser':
        $edituserController = new usersController();
        $edituserController->editUser();
        break;

    case 'deleteuser':
        $deleteUserController = new usersController();
        $deleteUserController->deleteUser();
        break;

    case 'indextag':
        $indextagController = new tagsController();
        $indextagController->indextag();
        break;

    case 'addtag':
        $addtagController = new tagsController();
        $addtagController->addTag();
        break;

    case 'edittag':
        $edittagController = new tagsController();
        $edittagController->editTag();
        break;

    case 'deletetag':
        $deleteTagController = new tagsController();
        $deleteTagController->deletetag();
        break;
    
    default:
        $page404Controller = new frontEndController();
        $page404Controller->page404();
        break;          
}

?>