<?php

abstract class Manager
{
    protected function bddConnect()
    {
        $bdd = new PDO('mysql:dbname=blog;host=localhost', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

        return $bdd;
    }
}