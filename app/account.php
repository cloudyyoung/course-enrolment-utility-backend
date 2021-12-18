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

        if(!$result){
            return false;
        }

        //if the result is wrong or incorrect password or username then we terminate
        $result = $result->fetch_all(MYSQLI_ASSOC);
        if (count($result) == 0)
        {
            return null;
        }

        $result = $result[0];

        //check if the account is a student account
        $sql2 = "SELECT `U`.`user_id`, `U`.`email`
                FROM `user` as `U`, student as S
                WHERE `U`.`user_id` = `S`.`user_id` AND
                `U`.`email` = '$username' AND `U`.`password` = '$password'";        
        $result2 = mysqli_query($con, $sql2);    
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);

        //if the account is NOT a student account
        if (count($result) == 0)
        {
            $result["type"] = "admin";
        }
        else
        {
            $result["type"] = "student";
        }

        //set the session and return the result
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
            return false;
        }
        else
        {
            //get the current user's id and type
            $currentID = $_SESSION['user_id'] ;
            $currentType= $_SESSION['type'];

            //get the email of the user and account id
            $sql = "SELECT `U`.`user_id`, `U`.`email`
            FROM `user` as `U`
            WHERE `U`.`user_id` ='$currentID'";
            $result = mysqli_query($con, $sql);

            $result = $result->fetch_all(MYSQLI_ASSOC);
            $result = $result[0];

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
            return false;
        }        
        else if ($_SESSION['type']!= "student")
        {
            return false;
        }

        $currentID = $_SESSION['user_id'];


        //get all the major
        $sql = "SELECT `program_id` as major
                FROM `major_in`
                WHERE `user_id` = '$currentID'";   
                
        //get all the minor 
        $sql1 = "SELECT `program_id` as minor
                FROM `minor_in`
                WHERE `user_id` = '$currentID'";  

        //get all the concentrations
        $sql2 = "SELECT `concentration_name`
                FROM `concentrate_in`
                WHERE `user_id` = '$currentID'";  

        //get all course taken
        $sql3 = "SELECT *
                FROM `enrolls`
                WHERE `user_id` = '$currentID'";  


        //get the results from the query and put them all the result 3
        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);

        $result3["major"] = [];
        $result3["minor"] = [];
        $result3["concentration_name"] = [];

        foreach ($result as &$insert)
        {
            array_push($result3["major"], $insert["major"]);
        }   

        foreach ($result1 as &$insert)
        {
            array_push($result3["minor"], $insert["minor"]);
        }  

        foreach ($result2 as &$insert)
        {
            array_push($result3["concentration_name"], $insert["concentration_name"]);
        }       

        return $result3;


    }



    //End point 13
    public static function SetMajorMinor($con, $major, $minor)
    {
        $result = null;
        
        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false)
        {
            return false;
        }        
        else if ($_SESSION['type']!= "student")
        {
            return false;
        }

        $currentID = $_SESSION['user_id'];

        //delete major in and minor in before setting:
            $sql = "DELETE  FROM `major_in` 
                WHERE `user_id` = '$currentID'";
            mysqli_query($con, $sql);

            $sql = "DELETE  FROM `minor_in` 
                WHERE `user_id` = '$currentID'";
            mysqli_query($con, $sql);

        //insert each major one by one
        if($major == null){
            $major = "[]";
        }
        $major = json_decode($major);
        foreach ($major as &$insert) {

            $sql = "INSERT INTO `major_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            mysqli_query($con, $sql);
        }
        
        if($minor == null){
            $minor = "[]";
        }
        $minor = json_decode($minor);
        foreach ($minor as &$insert) {
            $sql = "INSERT INTO `minor_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            mysqli_query($con, $sql);
        }


        $result["major"] = $major;
        $result["minor"] = $minor;
        return $result;
    }


    //End point 14
    public static function SetPlan($con, $courses_id)
    {
        if (isset($_SESSION['user_id']) == false)
        {
            return false;
        }     
        else if ($_SESSION['type']!= "student")
        {
            return false;
        }
        
        $currentID = $_SESSION['user_id'];
        $courses_id = json_decode($courses_id);

        $sql = "DELETE  FROM `enrolls` 
                        WHERE `user_id` = '$currentID'";

        if (!mysqli_query($con, $sql))
        {
            return false;
        }

        foreach ($courses_id as &$insert) {
            $sql = "INSERT INTO `enrolls` (`user_id`, `course_id`) VALUES ('$currentID','$insert')";
            mysqli_query($con, $sql);            
        }

        return $courses_id;

        //delete then write
        /*
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
        return $result;*/

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