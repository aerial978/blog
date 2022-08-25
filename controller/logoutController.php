<?php

class logoutController extends basecontroller
{
    public function logout()
    {
        $this->setSession('logout', 'Thank you for your visit !');
        $this->unsetSession('auth');
        header('Location: index.php?page=login');
    }
    
    public function logout2()
    {
        $this->setSession('logout2', 'See you soon !');
        $this->unsetSession('auth');
        header('Location: index.php?page=home');
    }
}
