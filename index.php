<?php

$_GET["page"] == "home";

switch ($_GET["page"]) {

    case 'postslist':
        require "controller/FrontendController.php";
        $postslistController = new FrontendController();
        $postslistController->postslist();
        break;
    
    case 'postsingle':
        require "controller/FrontendController.php";
        $postsingleController = new FrontendController();
        $postsingleController->postsingle();
        break;

    case 'register':
        require "controller/FrontendController.php";
        $registerController = new FrontendController();
        $registerController->register();
        break;

    case 'login':
        require "controller/FrontendController.php";
        $loginController = new FrontendController();
        $loginController->login();
        break;

    case 'dashboard':
        require "controller/BackendController/DashboardController.php";
        $dashboardController = new DashboardController();
        $dashboardController->dashboard();
        break;

    case 'indexpost':
        require "controller/BackendController/PostsController.php";
        $indexpostController = new PostsController();
        $indexpostController->indexpost();
        break;

    case 'addpost':
        require "controller/BackendController/PostsController.php";
        $addpostController = new PostsController();
        $addpostController->addpost();
        break;

    case 'editpost':
        require "controller/BackendController/PostsController.php";
        $editpostController = new PostsController();
        $editpostController->editpost();
        break;

    case 'indexcomment':
        require "controller/BackendController/CommentssController.php";
        $indexcommentController = new CommentsController();
        $indexcommentController->indexcomment();
        break;

    case 'editcomment':
        require "controller/BackendController/CommentssController.php";
        $editcommentController = new CommentsController();
        $editcommentController->editcomment();
        break;

    case 'indexuser':
        require "controller/BackendController/UsersController.php";
        $indexuserController = new UsersController();
        $indexuserController->indexuser();
        break;

    case 'adduser':
        require "controller/BackendController/UsersController.php";
        $adduserController = new UsersController();
        $adduserController->adduser();
        break;

    case 'edituser':
        require "controller/BackendController/UsersController.php";
        $edituserController = new UsersController();
        $edituserController->edituser();
        break;

    case 'indextag':
        require "controller/BackendController/TagsController.php";
        $indextagController = new TagsController();
        $indextagController->indextag();
        break;

    case 'addtag':
        require "controller/BackendController/TagsController.php";
        $addtagController = new TagsController();
        $addtagController->addtag();
        break;

    case 'edittag':
        require "controller/BackendController/TagsController.php";
        $edittagController = new TagsController();
        $edittagController->edittag();
        break;
    
    default:
        require "Controller/FrontendController.php";
        $homeController = new FrontendController();
        $homeController->home();
}

?>