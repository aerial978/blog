<?php

namespace Hathier\Blog\Controller;

require_once 'vendor/autoload.php';

class BaseController{
    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $this->twig = new \Twig\Environment($loader,[
            'debug'=>true
       ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
    }
}