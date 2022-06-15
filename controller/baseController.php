<?php

require 'core/superglobal.php';

class baseController extends Superglobal
{
    public function number_words($string, $limit = 25, $fin = ' ...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
        
        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
            }
        echo rtrim($matches[0]).$fin;
    }

    public function authentification() 
    {
        if(!isset($_SESSION['auth'])) {
            $this->setSession('authentification','Login to access admin area !');
            header("Location: index.php?page=login");
        }
    }

    public function alreadyLog() 
    {
        if($this->issetSession('auth')) {
            $this->setSession('alreadylog','You are already logged in !');
            header("Location: index.php?page=dashboard");
        }
    }
}

?>