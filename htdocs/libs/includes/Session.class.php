<?php

require_once "Database.class.php";
class Session
{
    public static $isError =false;
    public static function start()
    {
        session_start();
    }

    public static function unset()
    {
        session_unset();
    }
    public static function destroy($id)
    {
        session_destroy();
        /*
        If UserSession is active, set it to inactive.
        */
        //changing database active 1 to 0
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function delete($key)
    {
        unset($_SESSION[$key]);
    }

    public static function isset($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function get($key, $default=false)
    {
        if (Session::isset($key)) {
            return $_SESSION[$key];
        } else {
            return $default;
        }
    }

    public static function renderPage()
    {
        Session::loadTemplate('_master');
    }

    public static function loadTemplate($name)
    {
        $script = $_SERVER['DOCUMENT_ROOT']."/_templates/$name.php";
        if (is_file($script)) {
            include $script;
        } else {
            Session::loadTemplate('_error');
        }
    }

    public static function currentScript()//return current script is that user requests
    {
        return basename($_SERVER['SCRIPT_NAME'], '.php');
    }

    public static function isAuthenticated()
    {
        return false;
    }
}
