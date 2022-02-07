<?php

require_once 'Controller/BaseController.php';

class DashboardController extends BaseController{

    public function dashboard()
    {
        echo $this->twig->render("backend/dashboard.html.twig",[
            'activemenu' => 'dashboardmenu' 
        ]);
    }
};
