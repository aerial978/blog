<?php

use blogmvc\model\UserManager;

class usersController extends baseController
{
    public function __construct()
    {
        $this->authentification();
    }

    public function indexUser()
    {
        $activeMenu = 'usermenu';

        if ($this->issetSession('auth', 'role') && $this->getSession('auth', 'role') == 1) {

            $userManager = new userManager();
            $indexUsers = $userManager->indexUser1();
        } else {

            $userManager = new userManager();
            $indexUsers = $userManager->indexUser2();
        }

        require('view/backend/users/indexuser.php');

        if ($this->issetSession('create') && $this->getSession('create') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('create'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('create');
        }

        if ($this->issetSession('update') && $this->getSession('update') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('update'); ?>",
                    icon: 'success',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
            $this->unsetSession('update');
        }

        if ($this->issetSession('process') && $this->getSession('process') != "") { ?>
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('process'); ?>",
                    icon: 'error',
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
<?php
            $this->unsetSession('process');
        }
    }

    public function addUser()
    {
        $activeMenu = 'usermenu';

        $errors = array();

        $this->setSession('input', '');

        if ($this->issetPost()) {

            if (empty($this->getPost('username')) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)', $this->getPost('username'))) {

                $errors['username'] = "Invalid username !";
            } else {

                $userManager = new UserManager();
                $getUserId = $userManager->getUserId();

                if ($getUserId) {
                    $errors['username'] = 'Username already used !';
                }
            }

            if (empty($this->getPost('name')) || !preg_match('(^[A-Z][a-z]*$)', $this->getPost('name'))) {

                $errors['username'] = "Invalid name !";
            } else {

                $userManager = new UserManager();
                $getUserIdName = $userManager->getUserIdName();

                if ($getUserIdName) {
                    $errors['name'] = 'Name already used !';
                }
            }

            if ($this->issetFiles('picture') && $this->getFiles('picture', 'size') == 0) {
                $errors['picture'] = 'Select an image !';
            } else if ($this->issetFiles('picture') && $this->getFiles('picture', 'size') > 0) {

                if ($error = $this->getFiles('picture', 'error') > 0) {
                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $maxsize = 5000000;

                $picture = $this->getFiles('picture', 'name');
                $picture_tmp_name = $this->getFiles('picture', 'tmp_name');
                $picture_size = $this->getFiles('picture', 'size');
                $upload_folder = "images/";

                if ($picture_size >= $maxsize) {
                    $errors['size'] = 'File too large !';
                }

                $picture_ext = pathinfo($picture, PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($picture_ext_min, $allowed_ext)) {
                    $errors['extension'] = 'file extension is not allowed !';
                }
            }

            if (empty($this->getPost('email')) || !filter_var($this->getPost('email'), FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Invalid email !";
            } else {

                $userManager = new UserManager();
                $getUserEmail = $userManager->getUserEmail();

                if ($getUserEmail) {
                    $errors['email'] = 'Email already used !';
                }
            }

            if (empty($this->getPost('password')) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)', $this->getPost('password')) || $this->getPost('password') != $this->getPost('password_confirm')) {
                $errors['password'] = "Invalid password !";
            }

            $this->setSession('errors', $errors);

            if (empty($errors)) {
                if ($this->issetPost('role') && $this->getPost('role') == 2) {
                    $role = $this->getPost('role');
                } else {
                    $role = 1;
                }

                move_uploaded_file($picture_tmp_name, $upload_folder);
                $password = password_hash($this->getPost('password'), PASSWORD_BCRYPT);

                $userManager = new UserManager();
                $insertUser = $userManager->insertUser($password, $role);

                $this->setSession('create', 'Creation successfully !');
                header('Location: index.php?page=indexuser');
            }
        }

        require('view/backend/users/adduser.php');

        $this->unsetSession('errors');
        $this->unsetSession('input');
    }

    public function editUser()
    {
        $activeMenu = 'usermenu';

        $errors = array();

        if ($this->issetGet('id')) {

            $id = $this->getGet('id');

            $userManager = new UserManager();
            $editUser = $userManager->editUser($this->getGet('id'));
        } else {

            $errors['id'] = 'You need a user id to change it !';
        }

        if ($this->issetPost()) {

            $username = $this->getPost('username');
            $name = $this->getPost('name');
            $email = $this->getPost('email');
            $password = $this->getPost('password');

            $this->setSession('input', $_POST);

            if (empty($this->getPost('username')) || !preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)', $this->getPost('username'))) {

                $errors['username'] = "Username is not valid !";
            } else {
                $userManager = new userManager();
                $updateUsername = $userManager->updateUsername($username, $id);
            }

            if (empty($this->getPost('name')) || !preg_match('(^[A-Z][a-z]*$)', $this->getPost('name'))) {

                $errors['name'] = "Name is not valid !";
            } else {
                $userManager = new userManager();
                $updateName = $userManager->updateName($name, $id);
            }

            if (!empty($this->getFiles('picture', 'name'))) {

                if ($error = $this->getFiles('picture', 'error') > 0) {

                    $errors['transfert'] = 'There was a problem with the transfer !';
                }

                $maxsize = 5000000;

                $picture = $this->getFiles('picture', 'name');
                $picture_tmp_name = $this->getFiles('picture', 'tmp_name');
                $picture_size = $this->getFiles('picture', 'size');
                $upload_folder = "images/";

                if ($picture_size >= $maxsize) {
                    $errors['size'] = '' . $picture . ' is too large ( 5 Mo max ) !';
                }

                $picture_ext = pathinfo($picture, PATHINFO_EXTENSION);
                $picture_ext_min = strtolower($picture_ext);
                $allowed_ext = array('jpg', 'jpeg', 'png', 'gif');

                if (!in_array($picture_ext_min, $allowed_ext)) {
                    $errors['extension'] = '' . $picture . ' extension is not allowed ( jpg, jpeg, png and gif only) !';
                }

                if (!isset($errors['size']) && !isset($errors['extension'])) {
                    $this->setSession('picture', $this->getFiles('picture'));
                }

                if (empty($errors)) {
                    move_uploaded_file($picture_tmp_name, $upload_folder);

                    $userManager = new userManager();
                    $updatePicture = $userManager->updatePicture($picture, $id);
                }
            }

            if (empty($this->getPost('email')) || !filter_var($this->getPost('email'), FILTER_VALIDATE_EMAIL)) {

                $errors['email'] = "Invalid email !";
            } else {
                $userManager = new UserManager();
                $updateEmail = $userManager->updateEmail($email, $id);
            }



            $password = $this->getPost('password');

            if (!preg_match('(^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$)', $this->getPost('password')) || $this->getPost('password') != $this->getPost('password_confirm')) {
                $errors['password'] = "Invalid password !";
            }


            $this->setSession('errors', $errors);

            if (empty($errors)) {

                if ($this->issetPost('role') && $this->getPost('role') == 2) {
                    $role = $this->getPost('role');
                } else {
                    $role = 1;
                }

                $password = password_hash($this->getPost('password'), PASSWORD_BCRYPT);

                $userManager = new userManager();
                $updatePasswordRole = $userManager->updatePasswordRole($password, $role, $id);

                $this->setSession('update', 'Update successfully !');
                header('Location: index.php?page=indexuser');
            }
        }
        require('view/backend/users/edituser.php');
        $this->unsetSession('errors');
        $this->unsetSession('input');
    }

    public function deleteUser()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            if ($this->getSession('auth')['role'] == 2 | $this->getGet('id') == $this->getSession('auth')['id']) {
                if ($this->issetGet('id') && !empty($this->getGet('id'))) {

                $to         =  $this->getSession('auth')['email'];
                $subject    = 'Blog account closure';
                $message    = "Your account has been successfully terminated.";
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'From: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

                mail($to, $subject, $message, $headers);
/*
                    $userManager = new UserManager();
                    $userManager->deleteUser($this->getGet('id'));

                    echo json_encode([
                        'code' => 200,
                        'role' => 1
                    ]); */
                }
            } else {
                header('location: ?page=page404');
            }
        } else {
            header('location: ?page=page404');
        }
    }
}
