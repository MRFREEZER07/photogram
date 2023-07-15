<?php

require_once 'UserSession.class.php';
include_once __DIR__ ."/../traits/SQLGetterSetter.trait.php";
 
class User
{
    private $conn;

    public function __construct($username)
    {
        //check wheater user exist or not
        $this->conn = Database::getConnection();
        $this->username =$username;
        $this->id =null;
        $sql = "SELECT * FROM `auth` WHERE `username`= '$username' OR `id` = '$username' LIMIT 1";
        $result = $this->conn->query($sql);

        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            //print_r($row);
           // echo $row['username'];
            //return $row;
            $this->id = $row['id'];
          
        } else {
            throw new Exception("Username does't exist");
        }
    }


    public static function signup($username, $pass, $email)
    {
        $options = [
            'cost' => 12,
        ];
        $password= password_hash($pass, PASSWORD_BCRYPT, $options);
        $conn =Database::getConnection();

        $query="INSERT INTO `auth` (`username`, `password`, `email`, `active`)
        VALUES ('$username', '$password', '$email', '0');";
        echo $query;
        $result =$conn->query($query);
        echo $result;
        if ($result === true) {
            $error = false;
        } else {
            $error= true;
        }

        return $error;
    }

    public static function login($user, $pass)
    {
        $query = "SELECT * FROM `auth` WHERE `username` = '$user'";
        $conn = Database::getConnection();
        $result = mysqli_query($conn, $query);
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            //print_r($row);

            if (password_verify($pass, $row['password'])) {
                /*
                1. Generate Session Token
                2. Insert Session Token
                3. Build session and give session to user.
                */
                //echo  $row['username'];
                return $row['username'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

   

    public function setDob($year, $month, $day)
    {
        if (checkdate($month, $day, $year)) { //checking data is valid
            return $this->_set_data('dob', "$year.$month.$day");
        } else {
            return false;
        }
    }

    public static function getDetails($username){
        $sql = "SELECT * FROM `auth` WHERE `username`= '$username' OR `id` = '$username' LIMIT 1";
        $conn = Database::getConnection();
        $result = $conn->query($sql);
        if ($result->num_rows) {
            $row = $result->fetch_assoc();
            return $row;         
        } else {
            throw new Exception("Username does't exist");
        }
    }
}
