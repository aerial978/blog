<?php

require_once 'Model/Manager.php';

class FormManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function contactForm()
    {
        

    }
}