<?php

require_once 'controller/BaseController.php';

class DashboardController extends BaseController{

    public function dashboard(){
        echo $this->twig->render("dashboard.html.twig",);
    }
};
