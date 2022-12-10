<?php

use blogmvc\model\formManager;

class registerController extends baseController
{
    public function __construct()
    {
        $this->alreadyLog();
    }

    public function register()
    {
        $activeMenu = 'signupmenu';

        if ($this->issetPost()) {
            $errors = array();

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

            $this->setSession('input', $_POST);

            if (empty($this->getPost('username')) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^*-]).{8,}$)', $this->getPost('username'))) {
                $errors['username'] = "Invalid username !";
            } else {
                $formManager = new formManager();
                $registerUsername = $formManager->registerUsername($this->getPost('username'));

                if ($registerUsername) {
                    $errors['username'] = 'Username already used !';
                }
            }

            if (empty($this->getPost('name')) || !preg_match('(^[A-Z][a-z]*$)', $this->getPost('name'))) {
                $errors['name'] = "Invalid name !";
            } else {
                $formManager = new formManager();
                $registerName = $formManager->registerName($this->getPost('name'));

                if ($registerName) {
                    $errors['name'] = 'Name already used !';
                }
            }

            if (empty($this->getPost('email')) || !filter_var($this->getPost('email'), FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email !";
            } else {
                $formManager = new formManager();
                $user = $formManager->registerEmail($this->getPost('email'));

                if ($user) {
                    $errors['email'] = 'Email already used !';
                }
            }

            if (empty($this->getPost('password')) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^*-]).{8,}$)', $this->getPost('password')) || $this->getPost('password') != $this->getPost('password_confirm')) {
                $errors['password'] = "Invalid password !";
            }

            if (empty($errors)) {
                $password = password_hash($this->getPost('password'), PASSWORD_BCRYPT);
                $token = bin2hex(random_bytes(60));

                $formManager = new formManager();
                $registerUser = $formManager->registerUser(htmlspecialchars($this->getPost('username')), htmlspecialchars($this->getPost('name')), htmlspecialchars($this->getPost('email')), $password, $token);

                if ($registerUser != NULL) {
                    $to         = $this->getPost('email');
                    $subject    = 'Confirmation of your account';
                    $message    = "In order to validate your registration, please <a href='http://localhost/blogmvc/index.php?page=confirmation&id=$registerUser&token=$token'>click on this link</a>";
                    $headers    = 'MIME Version 1.0\r\n';
                    $headers    = 'FROM: Your name <info@address.com>' . "\r\n";
                    $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                    mail($to, $subject, $message, $headers);

                    $this->setSession('register', "Your registration successful !");
                    header('Location: index.php?page=home');
                } else {
                    $errors['process'] = "There was a problem with a data processing !";
                }
            }
        }

        $token = bin2hex(random_bytes(32));
        $this->setSession('csrf_token', $token);
        $this->setSession('csrf_token_time', time() + 3600);

        require('view/account/register.php');
        $this->unsetSession('input');
    }

    public function confirmation()
    {
        $token = $this->getGet('token');

        if ($this->issetGet('id') && $this->issetGet('token')) {

            $formManager = new formManager();
            $tokenUser = $formManager->tokenUser($this->getGet('id'), $this->getGet('token'));

            if ($tokenUser && $tokenUser['token_confirm'] == $token) {
                $formManager = new formManager();
                $tokenConfirm = $formManager->tokenConfirm($this->getGet('id'));

                if ($tokenConfirm == true) {
                    $this->setSession('auth', $tokenUser);
                    $this->setSession('confirmation', "Your account has been validated !");
                    header('Location: index.php?page=home');
                } else {
                    $this->setSession('process', "There was a problem with a data processing !");
                    header('Location: index.php?page=login');
                }
            } else {
                $this->setSession('invalid', "Link is no longer valid !");
                header('Location: index.php?page=login');
            }
        }
    }
}
