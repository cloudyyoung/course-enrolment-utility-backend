<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;
use App\InternalErrorException;
use App\IncorrectUsernameOrPasswordException;

class Account
{
    private static function AuthenticateSession()
    {
        if (isset($_SESSION['user_id']) == false) {
            throw new UnauthorizedAccessException();
        }
    }

    //End point 1
    public static function LogIn($username, $password)
    {
        $sql = "CALL `EP1_ LogIn`('$username', '$password');";
        $result = Flight::mysql($sql);
        if (!$result) {
            throw new MySQLDatabaseQueryException();
        }

        //if the result is wrong or incorrect password or username then we terminate
        $result = $result->fetch_all(MYSQLI_ASSOC);
        if (count($result) == 0) {
            throw new IncorrectUsernameOrPasswordException();
        }

        $result = $result[0];
        unset($result["password"]);
        
        //set the session and return the result
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['type'] = $result['type'];
        
        return $result;
    }

    //End point 3
    public static function AccountInformation()
    {
        self::AuthenticateSession();
        
        //get the current user's id and type
        $user_id = $_SESSION['user_id'];

        //get the email of the user and account id
        $sql = "CALL `EP3_AccountInformation`('$user_id');";
        $result = Flight::mysql($sql);

        if(!$result) {
            throw new MySQLDatabaseQueryException();
        } else if ($result->num_rows == 0) {
            throw new UnauthorizedAccessException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        return $result;
    }


    //End point 10
    //INCOMPLETE, DO LATER
    public static function StudentInformation()
    {
        $result = null;

        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false) {
            return false;
        } else if ($_SESSION['type'] != "student") {
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
        //get course ID only
        $sql3 = "SELECT `course_id`
                FROM `enrolls`
                WHERE `user_id` = '$currentID'";

        $result_out = [];
        //get the results from the query and put them all the result 3
        $result = Flight::mysql($sql);
        $result1 = Flight::mysql($sql1);
        $result2 = Flight::mysql($sql2);
        $result3 = Flight::mysql($sql3);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);


        $result_out["major"] = [];
        $result_out["minor"] = [];
        $result_out["concentration_name"] = [];
        $result_out["course_id"] = [];

        foreach ($result as &$insert) {
            array_push($result_out["major"], $insert["major"]);
        }

        foreach ($result1 as &$insert) {
            array_push($result_out["minor"], $insert["minor"]);
        }

        foreach ($result2 as &$insert) {
            array_push($result_out["concentration_name"], $insert["concentration_name"]);
        }

        foreach ($result3 as &$insert) {
            array_push($result_out["course_id"], $insert["course_id"]);
        }
        return $result_out;
    }


    //End point 13
    public static function SetMajorMinor($major, $minor, $concentration)
    {
        $result = null;

        //return null if the user is NOT logged in or the user is NOT a student
        if (isset($_SESSION['user_id']) == false) {
            return false;
        } else if ($_SESSION['type'] != "student") {
            return false;
        }

        $currentID = $_SESSION['user_id'];

        //delete major in, minor in and concentrate in before setting:
        $sql = "DELETE  FROM `major_in` 
                WHERE `user_id` = '$currentID'";
        Flight::mysql($sql);

        $sql = "DELETE  FROM `minor_in` 
                WHERE `user_id` = '$currentID'";
        Flight::mysql($sql);

        $sql = "DELETE  FROM `concentrate_in` 
                WHERE `user_id` = '$currentID'";
        Flight::mysql($sql);


        //insert each major and concentration one by one
        if ($major == null) {
            $major = "[]";
        }
        $major = json_decode($major);
        $result["major"] = $major;
        foreach ($major as &$insert) {

            $sql = "INSERT INTO `major_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            Flight::mysql($sql);
        }

        if ($minor == null) {
            $minor = "[]";
        }
        $minor = json_decode($minor);
        $result["minor"] = $minor;
        foreach ($minor as &$insert) {
            $sql = "INSERT INTO `minor_in` (`user_id`, `program_id`) VALUES ('$currentID','$insert')";
            Flight::mysql($sql);
        }

        if ($concentration == null) {
            $concentration = "[]";
        }

        $concentration = json_decode($concentration);
        $result["concentration"] = $concentration;
        foreach ($concentration as &$insert) {
            $pid = $insert['program_id'];
            $name = $insert['name'];
            $sql = "INSERT INTO `concentrate_in` (`user_id`,`program_id`, `concentration_name`) VALUES ('$currentID', '$pid' ,' $name ')";
            Flight::mysql($sql);
        }

        //$result["major"] = $major;
        // $result["minor"] = $minor;
        //$result["concentration"] = $concentration;
        return $result;
    }


    //End point 14
    public static function SetPlan($term, $year, $course_id)
    {
        if (isset($_SESSION['user_id']) == false) {
            return false;
        } else if ($_SESSION['type'] != "student") {
            return false;
        }

        $currentID = $_SESSION['user_id'];
        $course_id = json_decode($course_id);

        if ($course_id == null) {
            $course_id = "[]";
        }

        $sql = "DELETE  FROM `enrolls` 
                        WHERE `user_id` = '$currentID' AND `term` = '$term' AND `year` = '$year'";

        $result = Flight::mysql($sql);
        if ($result === false) {
            return false;
        }

        foreach ($course_id as &$insert) {
            $sql = "INSERT INTO `enrolls` (`user_id`,`course_id` ,`term`,`year`) VALUES ('$currentID','$insert','$term','$year')";
            Flight::mysql($sql);
        }


        $result_out = array("course_id" => $course_id);
        return $result_out;
    }

    //End point 2
    public static function Signup($email, $password)
    {
        $sql = "CALL `EP2_SignUp`('$email', '$password');";
        $result = Flight::mysql($sql);
        if (!$result) {
            // If mysql error is complaining about duplicated entry
            $message = Flight::get("mysql_connection")->error;
            if(str_starts_with($message, "Duplicate entry")){
               throw new EmailAlreadyRegisteredException();
            }
            
            throw new MySQLDatabaseQueryException();
        }
        
        $result = $result->fetch_all(MYSQLI_ASSOC);
        if(count($result) == 0){
            throw new InternalErrorException();
        }

        $result = $result[0];
        unset($result["password"]);

        $result["type"] = "student";
        return $result;
    }

    //End point 9
    public static function Enroll_Plan($term, $year)
    {
        $currentID = $_SESSION['user_id'];
        $sql = "SELECT `course_id`
                FROM `enrolls`
                WHERE `user_id` = '$currentID' AND `term` = '$term' AND `year` = '$year'";
        $result = Flight::mysql($sql);
        if (!$result) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result_out_list = [];
        foreach ($result as &$insert) {
            array_push($result_out_list, $insert["course_id"]);
        }
        $result_out = array("course_id" => $result_out_list);

        return $result_out;
    }

    //End point 15
    public static function View_Stat()
    {
        $type = $_SESSION["type"];
        if ($type != "admin") {
            return null;
        }

        $sql = "SELECT COUNT(*) AS `totalUsers`
                FROM `user`";
        $result = Flight::mysql($sql);
        if (!$result) {
            return false;
        }

        $sql = "SELECT COUNT(*) AS `totalCourses`
                FROM `course`";
        $result1 = Flight::mysql($sql);
        if (!$result1) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];

        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result1 = $result1[0];

        $result_out = array(
            "totalUsers" => $result["totalUsers"],
            "totalCourses" => $result1["totalCourses"]
        );

        return $result_out;
    }
}
