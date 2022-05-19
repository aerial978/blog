<?php

abstract class Superglobal {

    public function issePost($key) {
        if($key) {
            if(isset($_POST[$key]) || !empty($_POST[$key])) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            if(isset($_POST) || !empty($_POST)) {
                return TRUE;
            } else {
                return FALSE;
            }
        }    
    }

    public function issetPost($key = NULL) {
        if($key) {
            if(isset($_POST[$key]) && !empty($_POST[$key])) {
                return TRUE;
            } else {
                return FALSE;
            } 
        } else {
            if(isset($_POST) && !empty($_POST)) {
                return TRUE;
            } else {
                return FALSE;
            } 
        }    
    }

    public function setPost($key,$value) {
        $_POST[$key] = $value;      
    }

    public function getPost($key) {
        return $_POST[$key];
    }

    public function issetGet($key = NULL) {
        if($key) {
            if(isset($_GET[$key]) && !empty($_GET[$key])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function setGet($key,$value) {
        $_GET[$key] = $value;      
    }

    public function getGet($key) {
        return $_GET[$key];
    }

    public function issetFiles($key = NULL) {
        if($key) {
            if(isset($_FILES[$key])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function getFiles($key1,$key2 = NULL) {
        if($key1 && $key2) {
            return $_FILES[$key1][$key2];      
        } else {
            return $_FILES[$key1]; 
        }
    }

    public function issetSession($key = NULL) {
        if($key) {
            if(isset($_SESSION[$key]) && !empty($_SESSION[$key])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function setSession($key,$value) {
        $_SESSION[$key] = $value;      
    }

    public function getSession($key) {
        return $_SESSION[$key];
    }

    public function unsetSession($key) {
        unset($_SESSION[$key]);    
    }

  
}

?>