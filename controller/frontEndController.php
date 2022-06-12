<?php

use blogmvc\model\postManager;
use blogmvc\model\tagManager;
use blogmvc\model\commentManager;
use blogmvc\model\userManager;

class frontEndController extends baseController
{
    private $postManager;
    private $tagManager;
    private $commentManager;

    public function __construct()
    {
        $this->postManager = new PostManager();
        $this->tagManager = new tagManager();
        $this->commentManager = new commentManager();
    }

    public function home()
    {
        $activeMenu = 'homemenu';

        $posts = $this->postManager->getPosts(5);
        $listTags = $this->tagManager->listTags();
        $comments = $this->commentManager->getComments();

        if ($this->issetPost()) {

            $errors = array();

            $name = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

            $this->setSession('input', $_POST);

            if ($this->issetPost('csrf_token') && $this->issetSession('csrf_token')) {
                if ($this->getpost('csrf_token') == $this->getSession('csrf_token')) {
                    if (time() >= $this->getSession('csrf_token_time')) {
                        $errors['csrf_token_time'] = 'CSRF token expired, reload the form !';
                    }
                    $this->unsetSession('csrf_token');
                    $this->unsetSession('csrf_token_time');
                } else {
                    $errors['tokensproblem'] = 'Problem with CSRF token verification !';
                }
            } else {
                $errors['tokenset'] = 'CSRF token not defined !';
            }

            if (!isset($_POST['name']) || $this->getPost('name') == "") {
                $errors['name'] = 'Name required !';
            }

            if (!isset($_POST['email']) || $this->getPost('email') == "" || !filter_var($this->getPost('email'), FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email invalid !';
            }

            if (!isset($_POST['message']) || $this->getPost('message') == "") {
                $errors['message'] = 'Message is required or invalid !';
            }

            if (empty($errors)) {
                $headers = 'FROM: ' . $this->getPost('email');
                mail('mhathier@gmail.com', 'contact blog de ' . $this->getPost('name'), $this->getPost('message'), $headers);

                $this->setSession('message', 'Message sent success !');
            }
        }

        // Generation du token et session

        $token = bin2hex(random_bytes(32));
        $this->setSession('csrf_token', $token);
        $this->setSession('csrf_token_time', time() + 3600);

        require 'view/frontend/home.php';
        unset($errors);
        $this->unsetSession('input');

        if ($this->issetSession('message') && $this->getSession('message') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?php $this->getSession('message'); ?>",
                    imageUrl: 'assets/images/letter_red.png',
                    imageWidth: 100,
                    imageHeight: 100,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('message');
        }

        if ($this->issetSession('register') && $this->getSession('register') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?php $this->getSession('register'); ?>",
                    text: "Check your inbox for a confirmation email !",
                    imageUrl: 'assets/images/letter_red.png',
                    imageWidth: 100,
                    imageHeight: 100,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('register');
        }

        if ($this->issetSession('confirmation') && $this->getSession('confirmation') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?php $this->getSession('confirmation'); ?>",
                    text: "You are indentified now !",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('confirmation');
        }
    }

    public function postsList()
    {
        $activeMenu = 'postsmenu';

        $posts = $this->postManager->getPosts(100);
        $listTags = $this->tagManager->listTags();
        $comments = $this->commentManager->getComments();

        require('view/frontend/postslist.php');
    }

    public function postSingle()
    {
        $activeMenu = 'postsmenu';

        $posts = $this->postManager->getPosts(5);
        $listTags = $this->tagManager->listTags();
        $comments = $this->commentManager->getComments();

        if ($this->issetGet('id')) {

            $postManager = new postManager();
            $singlePost = $postManager->singlePost($this->getGet('id'));

            $commentManager = new commentManager();
            $countCommentsPosts = $commentManager->countCommentsPost($this->getGet('id'));

            $commentManager = new commentManager();
            $listComments = $commentManager->listComments($this->getGet('id'));
        } else {
            header('location: ?page=page404');
        }

        if ($this->issetPost()) {

            $errors = array();

            if (htmlentities($this->issetPost('submit')) && empty($this->getPost('name_author'))) {
                $errors['name_author'] = 'Your name is required !';
            }

            if (isset($_POST['submit']) && empty($this->getPost('email_author')) || !filter_var($this->getPost('email_author'), FILTER_VALIDATE_EMAIL)) {
                $errors['email_author'] = 'Your email is required or invalid !';
            }

            if (isset($_POST['submit']) && empty($this->getPost('comment'))) {
                $errors['comment'] = 'Your comment is required !';
            }

            if (empty($errors)) {

                $commentManager = new commentManager();
                $insertComment = $commentManager->insertComment();

                $this->setSession('comment', 'Comment sent successfully !');
            }
        }
        require('view/frontend/postsingle.php');

        if ($this->issetSession('comment') && $this->getSession('comment') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?php $this->getSession('comment'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
<?php
            unset($_SESSION['comment']);
        }
    }

    public function userPosts()
    {
        $activeMenu = 'postsmenu';

        $posts = $this->postManager->getPosts(100);
        $listTags = $this->tagManager->listTags();
        $comments = $this->commentManager->getComments();

        if ($this->issetGet('id')) {

            $userManager = new userManager();
            $getUsername = $userManager->getUsername($this->getGet('id'));

            $postManager = new postManager();
            $userPosts = $postManager->userPost($this->getGet('id'));

            if ($userPosts === false) {
                header('location: ?page=page404');
            }
        }
        require('view/frontend/userposts.php');
    }

    public function tagPosts()
    {
        $activeMenu = 'postsmenu';

        $posts = $this->postManager->getPosts(100);
        $listTags = $this->tagManager->listTags();
        $comments = $this->commentManager->getComments();

        if ($this->issetGet('id')) {

            $tagManager = new tagManager();
            $tag = $tagManager->gettag($this->getGet('id'));

            $postManager = new postManager();
            $tagPosts = $postManager->tagPost($this->getGet('id'));

            if ($tag == false) {
                header('location: ?page=page404');
            }
        }
        require('view/frontend/tagposts.php');
    }

    public function page404()
    {
        require('view/error/page404.php');
    }
}
