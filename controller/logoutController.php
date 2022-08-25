<?php

class logoutController extends baseController
{

public function logout()
    {
        $this->setSession('logout','Thank you for your visit !');
        header('Location: index.php?page=login');
    }

}