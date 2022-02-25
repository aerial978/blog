<?php

require_once 'Controller/BaseController.php';

class DashboardController extends BaseController{

    public function dashboard()
    {
        $postManager = new PostManager();
        $countPosts = $postManager->countPosts();

        $commentManager = new CommentManager();
        $countComments = $commentManager->countComments();

        $userManager = new UserManager();
        $countUsers = $userManager->countUsers();

        $tagManager = new TagManager();
        $countTags = $tagManager->countTags();

        echo $this->twig->render("backend/dashboard.html.twig",[
            'activemenu' => 'dashboardmenu',
            'countposts' => $countPosts,
            'countcomments' => $countComments,
            'countusers' => $countUsers,
            'counttags' => $countTags
        ]);
    }
};
