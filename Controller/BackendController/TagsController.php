<?php

require_once('Controller/BaseController.php');

class TagsController extends BaseController{

    public function indextag(){
        echo $this->twig->render("backend/tags/indextag.html.twig");
    }

    public function addtag(){
        echo $this->twig->render("backend/tags/addtag.html.twig");
    }

    public function edittag(){
        echo $this->twig->render("backend/tags/edittag.html.twig");
    }
}