<?php

require_once 'Model/Manager.php';

class FormManager extends Manager
{
    public function __construct()
    {
        $this->bdd = $this->bddConnect();
    }

    public function loginUser($username)
    {
        $req = $this->bdd->prepare('SELECT * FROM users WHERE username = ?');
        $req->execute([$username]);
        $user = $req->fetch();
        
        return $user;
    }

    public function registerUsername($username)
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE username = ?");
        $req->execute([$username]);
        $user = $req->fetch();

        return $user;
    }

    public function registerEmail($email)
    {
        $req = $this->bdd->prepare("SELECT id FROM users WHERE email = ?");
        $req->execute([$email]);
        $user = $req->fetch();

        return $user;
    }

    public function registerUser($username,$email)
    {
        $req = $this->bdd->prepare("INSERT INTO users SET username = ?, email = ?, password = ?, token_confirm = ?");
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $token = bin2hex(random_bytes(60));
        $req->execute([$username, $email, $password, $token]);
        $user_id = $this->bdd->lastInsertId();
        $to         = $_POST['email'];
        $subject    = 'Confirmation of your account';
        $message    = "In order to validate your registration, please <a href='http://index.php?page=confirmation&id=$user_id&token=$token'>click on this link</a>";
        $headers    = 'MIME Version 1.0\r\n';
        $headers    = 'FROM: Your name <info@address.com>' . "\r\n";
        $headers   .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
        
        mail($to, $subject, $message, $headers);

    }

}
