<?php

require_once('BaseController.php');

class TagsController extends BaseController{

    public function indextag(){
        echo $this->twig->render("indextag.html.twig");
    }

    public function addtag(){
        echo $this->twig->render("addtag.html.twig");
    }

    public function edittag(){
        echo $this->twig->render("edittag.html.twig");
    }
}