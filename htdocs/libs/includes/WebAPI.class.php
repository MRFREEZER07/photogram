<?php

require_once 'Database.class.php';

class WebAPI
{
    public function __construct()
    {
        Database::getConnection();
    }
    public function inititateSession()
    {
        Session::start();
    }
}
