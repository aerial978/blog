<?php

$_GET["page"] == "home";

switch ($_GET["page"]) {

    case 'home':
        require "Controller/FrontendController.php";
        $homeController = new FrontendController();
        $homeController->home();
        break;

    case 'postslist':
        require "Controller/FrontendController.php";
        $postslistController = new FrontendController();
        $postslistController->postslist();
        break;
    
    case 'postsingle':
        require "Controller/FrontendController.php";
        $postsingleController = new FrontendController();
        $postsingleController->postsingle();
        break;

    case 'userposts':
        require "Controller/FrontendController.php";
        $userpostsController = new FrontendController();
        $userpostsController->userposts();
        break;

    case 'tagposts':
        require "Controller/FrontendController.php";
        $tagpostsController = new FrontendController();
        $tagpostsController->tagposts();
        break;

    case 'register':
        require "Controller/FrontendController.php";
        $registerController = new FrontendController();
        $registerController->register();
        break;

    case 'login':
        require "Controller/FrontendController.php";
        $loginController = new FrontendController();
        $loginController->login();
        break;

    case 'forget':
        require "Controller/FrontendController.php";
        $forgetController = new FrontendController();
        $forgetController->forget();
        break;

    case 'dashboard':
        require "Controller/BackendController/DashboardController.php";
        $dashboardController = new DashboardController();
        $dashboardController->dashboard();
        break;

    case 'indexpost':
        require "Controller/BackendController/PostsController.php";
        $indexpostController = new PostsController();
        $indexpostController->indexpost();
        break;

    case 'addpost':
        require "Controller/BackendController/PostsController.php";
        $addpostController = new PostsController();
        $addpostController->addpost();
        break;

    case 'editpost':
        require "Controller/BackendController/PostsController.php";
        $editpostController = new PostsController();
        $editpostController->editpost();
        break;

    case 'indexcomment':
        require "Controller/BackendController/CommentsController.php";
        $indexcommentController = new CommentsController();
        $indexcommentController->indexcomment();
        break;

    case 'editcomment':
        require "Controller/BackendController/CommentsController.php";
        $editcommentController = new CommentsController();
        $editcommentController->editcomment();
        break;

    case 'indexuser':
        require "Controller/BackendController/UsersController.php";
        $indexuserController = new UsersController();
        $indexuserController->indexuser();
        break;

    case 'adduser':
        require "Controller/BackendController/UsersController.php";
        $adduserController = new UsersController();
        $adduserController->adduser();
        break;

    case 'edituser':
        require "Controller/BackendController/UsersController.php";
        $edituserController = new UsersController();
        $edituserController->edituser();
        break;

    case 'indextag':
        require "Controller/BackendController/TagsController.php";
        $indextagController = new TagsController();
        $indextagController->indextag();
        break;

    case 'addtag':
        require "Controller/BackendController/TagsController.php";
        $addtagController = new TagsController();
        $addtagController->addtag();
        break;

    case 'edittag':
        require "Controller/BackendController/TagsController.php";
        $edittagController = new TagsController();
        $edittagController->edittag();
        break;
    
    default:
        require "Controller/FrontendController.php";
        $page404Controller = new FrontendController();
        $page404Controller->page404();
        break;      
}

?>