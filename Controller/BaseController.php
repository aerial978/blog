<?php

require_once 'vendor/autoload.php';

class BaseController
    {
    public function __construct() {
        $loader = new \Twig\Loader\FilesystemLoader('view');
        $this->twig = new \Twig\Environment($loader,[
            'debug'=>true
       ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        /*$this->twig->addGlobal('session',$_SESSION);*/

        $this->globalVariables();
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
}