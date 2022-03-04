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
    }

    public function adduser(){
        echo $this->twig->render("backend/users/adduser.html.twig");
    }

    public function edituser(){
        echo $this->twig->render("backend/users/edituser.html.twig");
    }
}