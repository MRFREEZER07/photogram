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
        if (Session::isset("session_token")) {
            try {
                Session::$usersession = UserSession::authorize(Session::get("session_token"));
            } catch (Exception $e) {
                //TODO handle errot
            }
        }
    }
}
