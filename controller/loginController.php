<?php

use blogmvc\model\formManager;

class loginController extends baseController
{
    public function __construct()
    {
        $this->alreadyLog();
    }

    public function login()
    {    
        $activeMenu = 'signinmenu';

        if($this->issetPost()) {
            if($this->issetPost('csrf_token') && $this->issetSession('csrf_token')) {
                if($this->getpost('csrf_token') == $this->getSession('csrf_token')) {
                    if(time() >= $this->getSession('csrf_token_time')) {
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
        
            $formManager = new formManager();
            $user = $formManager->loginUser(htmlspecialchars($this->getPost('username')));

            if($user != false) {
                if($user['activation'] != 0) {
                    if(password_verify(htmlspecialchars($this->getPost('password')), $user['password'])) {
                        session_start();
                        $this->setSession('auth',$user);
                        
                        $this->setSession('login','Welcome to the Dashboard !');
                        header('Location: index.php?page=dashboard');
                    }  else {
                        $errors['danger'] = 'Incorrect username or password';
                    }
                } else { 
                    $danger['activation'] = 'Inactive account !';    
                }
            } else { 
                $errors['danger'] = 'Incorrect username or password';  
            }
        }

        // Generation du token et session

        $token = bin2hex(random_bytes(32));
        $this->setSession('csrf_token',$token);
        $this->setSession('csrf_token_time',time() + 3600);
    
        require('view/account/login.php');

        if($this->issetSession('invalid') && $this->getSession('invalid') != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $this->getSession('invalid') ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        $this->unsetSession('invalid');
        }

        if($this->issetSession('process') && $this->getSession('process') != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $this->getSession('process') ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        $this->unsetSession('process');
        }

        if(isset($danger['activation']) && $danger['activation'] != "") { ?>        
            <script>
                Swal.fire({
                title: "<?= $danger['activation'] ?>",
                text: "Please follow instructions sent by email !",
                icon: "error",
                confirmButtonColor: '#1aBC9C',
                });
            </script>
        <?php
        unset($danger['activation']);
        } 

        if($this->issetSession('reset') && $this->getSession('reset') != "") { ?>
            <script>
                Swal.fire({
                title: "<?= $this->getSession('reset') ?>",
                text: "Login please !",
                icon: "success",
                confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('forget');
        }

        if($this->issetSession('authentification') && $this->getSession('authentification') != "") { ?>
            <script>
                Swal.fire({
                title: "<?= $this->getSession('authentification') ?>",
                icon: "error",
                confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('authentification');
        }

        if($this->issetSession('logout') && $this->getSession('logout') != "") { 
            ?>        
            <script>
                Swal.fire({
                    title: "<?= $this->getSession('logout') ?>",
                    imageUrl: 'assets/images/avatar.png',
                    imageWidth: 200,
                    imageHeight: 200,
                    confirmButtonColor: '#1aBC9C',
                })
            </script>
        <?php
        $this->unsetSession('logout');
        }         

    }

    public function forget()
    {
        if($this->issetPost()) {
            if($this->issetPost('csrf_token') && $this->issetSession('csrf_token')) {
                if($this->getpost('csrf_token') == $this->getSession('csrf_token')) {
                    if(time() >= $this->getSession('csrf_token_time')) {
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

            $email = $this->getPost('email');
        
            $formManager = new formManager();
            $forgetUser = $formManager->forgetUser($email);

            if($forgetUser) {
                $forget_token = bin2hex(random_bytes(60));
        
                $formManager = new formManager();
                $updateForget = $formManager->updateForget($forget_token,$forgetUser);

                if($updateForget == NULL) {
                    $errors['danger'] = "There was a problem with a data processing !";
                }

                $user_id = $forgetUser['id'];

                $to         =  $email;
                $subject    = 'Resetting your password';
                $message    = "To reset your password, please <a href='http://localhost/blogmvc/index.php?page=reset&id=$user_id&token=$forget_token'>click on this link</a>";
                $headers    = 'MIME Version 1.0\r\n';
                $headers    = 'From: Your name <info@address.com>' . "\r\n";
                $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
                
                mail($to, $subject, $message, $headers);
        
                $this->setSession('forget','Check your inbox to reset password !'); 
            }  else {
                $errors['danger'] = "No account corresponds to this email address !";        
            }    
        }
        
        // Generation du token et session
        
        $token = bin2hex(random_bytes(32));
        $this->setSession('csrf_token',$token);
        $this->setSession('csrf_token_time',time() + 3600);

        require('view/account/forget.php');

        if($this->issetSession('forget') && $this->getSession('forget') != "") { ?>    
            <script>
                Swal.fire({
                title: "<?= $this->getSession('forget') ?>",
                imageUrl: 'assets/images/letter_red.png',
                imageWidth: 100,
                imageHeight: 100,
                confirmButtonColor: '#1aBC9C', 
                })
            </script>
        <?php
        $this->unsetSession('forget');
        }
    }

    public function reset()
    {
        if($this->issetPost('csrf_token') && $this->issetSession('csrf_token')) {
            if($this->getpost('csrf_token') == $this->getSession('csrf_token')) {
                if(time() >= $this->getSession('csrf_token_time')) {
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

        if($this->issetGet('id') && $this->issetGet('token')) {

            $formManager = new formManager();
            $resetUser = $formManager->resetUser();
        
            if($resetUser) {
                if($this->issetPost()) {

                    if(!empty($this->getPost('password')) && $this->getPost('password') == $this->getPost('password_confirm')) {
                        $password = password_hash($this->getPost('password'), PASSWORD_BCRYPT);

                        $formManager = new formManager();
                        $updateReset = $formManager->UpdateReset($password,$resetUser);

                        if($updateReset == NULL) {
                            $errors['danger'] = "There was a problem with a data processing !";
                        }
                        $this->setSession('auth',$resetUser);
                        $this->setSession('id',$resetUser['id']);
                        $this->setSession('username',$resetUser['username']);
                        $this->setSession('pictures',$resetUser['picture']);
                        $this->setSession('auth_role',$resetUser['role']);
        
                        $this->setSession('reset','Well done, your password has been reset !');
                        header('Location: index.php?page=login');                     
                    } else {
                        $errors['danger'] = "Password invalid !";
                    }
                } 
            } else {
                $this->setSession('invalid','Link is no longer valid !');
                header('Location: index.php?page=login');
            }
        } else {
            header('Location: index.php?page=login');  
        }
        
        // Generation du token et session

        $token = bin2hex(random_bytes(32));
        $this->setSession('csrf_token',$token);
        $this->setSession('csrf_token_time',time() + 3600);
        
        require('view/account/reset.php');
    }
}