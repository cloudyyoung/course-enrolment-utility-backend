<?php

namespace App;

//use MongoDB\Bson\ObjectId;
//use Flight;

//use App\Base;

class Account
{

    public function __construct($object)
    {

    }

    //End point 1
    public static function Authenticate($username, $password, $con)
    {
        $sql = "SELECT `U`.`user_id`, `U`.`email`
                FROM `user` as `U`
                WHERE `U`.`email` = '$username' AND `U`.`password` = '$password'";
        $result = mysqli_query($con, $sql);

        //if the result is wrong
        if (!$result)
        {
            return $result;
        }

        //check if the account is a student account
        $sql2 = "SELECT `U`.`user_id`, `U`.`email`
                FROM `user` as `U`, student as S
                WHERE `U`.`user_id` = `S`.`user_id` AND
                `U`.`email` = '$username' AND `U`.`password` = '$password'";        
        $result2 = mysqli_query($con, $sql2);    
        
        //if the account is NOT a student account
        if (!$result2)
        {
            $result["type"] = "admin";
        }
        else
        {
            $result["type"] = "student";
        }
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['type'] = $result['type'];
        return $result;
    }

    //End point 3
    public static function Account_Information($con)
    {
        $result = null;
        
        if (isset($_SESSION['user_id']) == false)
        {
            return $result;
        }
        else
        {
            //get the current user's id and type
            $currentID = $_SESSION['user_id'] ;
            $currentType= $_SESSION['type'];

            //get the email of the user
            $sql = "SELECT `U`.`user_id`, `U`.`email`
            FROM `user` as `U`
            WHERE `U`.`email` ='$currentID'";
            $result = mysqli_query($con, $sql);

            //add the type into the result and return
            $result['type'] = $currentType;
            return $result;

        }
    }


    //End point 10
    //INCOMPLETE, DO LATER
    public static function Student_Information($con)
    {
        $result = null;
        
        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false)
        {
            return $result;
        }        
        else if ($_SESSION['type']!= "student")
        {
            return $result;
        }

        $currentID = $_SESSION['user_id'];


        //get all the major
        $sql = "SELECT `program_id` as major
                FROM `major_in`
                WHERE `user_id` = '$currentID'";   
                
        //get all the minor 
        $sql2 = "SELECT `program_id` as minor
                FROM `minor_in`
                WHERE `user_id` = '$currentID'";  

        //get all the concentrations
        $sql3 = "SELECT `C`.`program_id`, `C`.`concentration_name`
                FROM `concentrate_in` as `C`
                WHERE `C`.`user_id` = '$currentID'";  

        //get all course taken
        $sql4 = "SELECT `M`.`program_id`
                FROM `major_in` as `M`
                WHERE `U`.`email` = '$currentID'";  
    }


/*
    //End point 13
    public static function SetMajorMinor($con, $major = null, $minor = null)
    {
        $result = null;
        
        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false)
        {
            return $result;
        }        
        else if ($_SESSION['type']!= "student")
        {
            return $result;
        }

        $currentID = $_SESSION['user_id'];

        //insert each major one by one
        foreach ($major as &$insert)
        {
            $sql = "INSERT INTO `major_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            mysqli_query($con, $sql);
        }

        foreach ($minor as &$insert)
        {
            $sql = "INSERT INTO `minor_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            mysqli_query($con, $sql);
        }

        $result["major"] = $major;
        $result["minor"] = $minor;
        return $result;
    }*/


    //End point 14
    public static function SetPlan($con, $term , $year, $courses)
    {
        $result = null;
        
        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false)
        {
            return $result;
        }        
        else if ($_SESSION['type']!= "student")
        {
            return $result;
        }

        $currentID = $_SESSION['user_id'];

        foreach ($courses as &$insert)
        {
            $sql = "INSERT INTO `enrolls` (`user_id`, `course_id`, `term`, `year`) VALUES ('$currentID','$insert', '$term', '$year')";
            mysqli_query($con, $sql);
        }

        $result["term"] = $term;
        $result["year"] = $year;
        $result["courses"] = $courses;
        return $result;

    }    


}



/*

    private static $account_db;
    public static $account;
    private $exist;
    public $account_id;
    public $username;
    private $password;
    public $nickname;

    public function __construct($object)
    {
        if (self::$account_db == null) {
            self::$account_db = Flight::get("larp_db")->account;
        }

        if (is_array($object)) $object = (object) $object;

        $account = null;
        if (isset($object->account_id)) {
            $account = self::$account_db->findOne(["_id" => new ObjectId($object->account_id)]);
        } else if (isset($object->username)) {
            $account = self::$account_db->findOne(["username" => $object->username]);
        }

        if ($account != null) {
            $this->exist = true;
            $this->account_id = (string)($account->_id);
            $this->username = $account->username;
            $this->password = $account->password;
            $this->nickname = $account->nickname;
        } else {
            $this->exist = false;
        }
    }

    public function dump()
    {
        return get_object_vars($this);
    }

    public static function SignIn($username, $password)
    {
        $account = new Account(["username" => $username]);

        if (!$account->exist || $account->password != $password) {
            return null;
        }

        self::$account = $account;
        $_SESSION["account_id"] = $account->account_id;

        return $account;
    }

    public static function Authenticate()
    {
        if (!isset($_SESSION["account_id"])) {
            return false;
        }

        $account_id = $_SESSION["account_id"];
        $account = new Account(["account_id" => new ObjectId($account_id)]);

        if (!$account->exist) {
            return false;
        }

        self::$account = $account;
        return true;
    }

    public static function SignOut()
    {
        $_SESSION["account_id"] = null;
    }
}
*/