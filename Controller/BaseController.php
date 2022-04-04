<?php

require_once 'vendor/autoload.php';
require_once 'model/FormManager.php';
require_once 'model/PostManager.php';
require_once 'model/TagManager.php';
require_once 'model/CommentManager.php';
require_once 'model/UserManager.php';

class BaseController
{
    public function __construct() 
    {
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $this->twig = new \Twig\Environment($loader,[
            'debug'=>true
       ]);

        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        $this->twig->addGlobal('session', $_SESSION);

        $this->globalVariables();

        $this->unset();

        /*$this->number_words($string, $limit = 25, $fin = ' ...');*/

    }

    public function globalVariables()
    {
        $postManager = new PostManager();
        $posts = $postManager->getPosts();
        $this->twig->addGlobal('posts',$posts);

        $tagManager = new TagManager();
        $tags = $tagManager->listTags();
        $this->twig->addGlobal('tags',$tags);

        $commentManager = new CommentManager();
        $comments = $commentManager->getComments();
        $this->twig->addGlobal('comments',$comments);
    }

    private function unset()
    {
        $filterUnset = new \Twig\TwigFilter('unset', function ($string) {
            unset($_SESSION[$string]);
        });

        $this->twig->addFilter($filterUnset);
    }
    
    /*public function number_words($string, $limit = 25, $fin = ' ...')
    {
        preg_match('/^\s*+(?:\S++\s*+){1,' .$limit. '}/u', $string, $matches);
        
        if (!isset($matches[0]) || strlen($string) === strlen($matches[0])) {
            return $string;
            }
        echo rtrim($matches[0]).$fin;
    }*/
}
