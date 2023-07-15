<?php

require_once "Database.class.php";
class Session
{
    public static $isError =false;
    public static $user =null;
    public static $usersession = null;
    
    public static function start()
    {
        session_start();
    }

    public static function unset()
    {
        session_unset();
    }
    public static function destroy()
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

    
    public static function getUser()
    {
        return Session::$user;
    }



    public static function getUserSession()
    {
        return Session::$usersession;
    }

    public static function renderPage()
    {
        Session::loadTemplate('_master');
    }

    public static function loadTemplate($name,$default=null)
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
        if (is_object(Session::getUserSession())) {
            return Session::getUserSession()->isValid();
        }
        return false;
    }

    public static function ensureLogin()
    {
        if (!Session::isAuthenticated()) {
            Session::set('_redirect',$_SERVER['REQUEST_URI']);
            header("Location: /login.php");
            die();
        }
    }

    public static function isOwnerOf($owner){
        $user = Session::getAllUserDetails();
        
        if($user['email']){
            if($user['email'] ==$owner){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public static  function getAllUserDetails(){
        $id = Session::$user->id;
        $query = "SELECT username,email FROM `auth` WHERE id = $id;";   
        $conn = Database::getConnection();
        $result =$conn->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            return $row;
        } else {
            throw new Exception("user Not Found");
        }

    }

}
