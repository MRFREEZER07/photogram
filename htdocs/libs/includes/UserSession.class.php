<?php



require_once "User.class.php";
require_once "Database.class.php";
class UserSession
{
    private $ip;
    private $agent;
    private $uid;
    private $id;
    private $active;
    private $time;

    public function __construct($token)
    {
        $conn =Database::getConnection();
        $query ="SELECT * FROM sessions WHERE token = '$token' LIMIT 1;";
        $result =$conn->query($query);
        //echo "$result->num_rows";
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            //print_r($row);
            $this->ip =$row['ip'];
            $this->agent =$row['user_agent'];
            $this->uid =$row['uid'];
            $this->id =$row['id'];
            $this->active =$row['active'];
            $this->time =$row['login_time'];
        } else {
            throw new Exception("session invalid");
        }
    }




    /**
     * This function will return a session ID if username and password is correct.
     *
     * @return_SessionID
     */

    public static function authenticate($user, $pass)
    {
        $username = User::login($user, $pass);
        // echo $username;
        if ($username) {
            $conn = Database::getConnection();
            $userobj = new User($username);
            $ip = $_SERVER['REMOTE_ADDR'];
            $agent = $_SERVER['HTTP_USER_AGENT'];
            $token = md5(rand(0, 9999999) . $ip . $agent . time());
            
            $query ="INSERT INTO `sessions` ( `uid`, `token`, `login_time`, `user_agent`, `ip`, `active`) VALUES ('$userobj->id', '$token', now(), '$agent', '$ip', '1');";

            $result =$conn->query($query);

            if ($result) {
                Session::set('session_token', $token);
                Session::set('uname',$username);
                return $token;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    /*
    * Authorize function have has 4 level of checks
        1.Check that the IP and User agent field is filled.
        2.Check if the session is correct and active.
        3.Check that the current IP is the same as the previous IP
        4.Check that the current user agent is the same as the previous user agent

        @return true else false;
    */

    public static function authorize($token)
    {
        $u = new UserSession($token);
        
        try {
            if (isset($_SERVER['REMOTE_ADDR']) and isset($_SERVER['HTTP_USER_AGENT'])) {
                if ($u->isActive() and $u->isValid()) {
                    if ($u->getIp()==$_SERVER['REMOTE_ADDR'] and $u->getUserAgent()==$_SERVER['HTTP_USER_AGENT']) {
                        Session::$user =$u->getUser();
                        return $u;
                    } else {
                        throw new Exception("ip doesn't match");
                    }
                } else {
                    $u->removeSession();
                    throw new Exception("invalid session");
                }
            } else {
                throw new Exception("IP and User_agent is null");
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function getIp()
    {
        return $this->ip;
    }

    public function getUser()
    {
        return new User($this->uid);
    }
    public function getUserAgent()
    {
        return $this->agent;
    }

    public function deactivate()
    {
        $uid = $this->uid;
        $query = "UPDATE `sessions` SET `active` = '0' WHERE `uid` = '$uid';";
        $conn = Database::getConnection();
        $result = $conn->query($query);
        return $result ? true : false;
    }
    //remove current sesssion
    public function removeSession()
    {
        $id= $this->id;
        $query = "DELETE FROM `sessions` WHERE ((`id` = '$id'));";
        $conn = Database::getConnection();
        $result =$conn->query($query);
        return $result ? true : false ;
    }

    public function isActive()
    {
        $active = $this->active;
        if ($active) {
            return $active ? true : false;
        }
    }

    public function isValid()
    {
        $time = $this->time;
        if (isset($time)) {
            $login_time =DateTime::createFromFormat('Y-m-d H:i:s', $time);
            if (3600 > time() - $login_time->getTimestamp()) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new Exception("login time is null");
        }
    }
}
