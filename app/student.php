<?php

namespace App;

use Flight;
use App\UnauthorizedAccessException;
use App\MySQLDatabaseQueryException;
use App\InternalErrorException;

class Student extends Account
{
    // End point 10 - Student Information
    public static function StudentInformation()
    {
        self::AuthenticateSession();
        
        $result = null;

        $user_id = $_SESSION['user_id'];


        //get all the major
        $sql = "CALL `EP10_StudentInformation`('$user_id');";
        $result = Flight::mysql($sql);
        if($result === false){
            throw new MySQLDatabaseQueryException();
        }else if ($result->num_rows == 0) {
            throw new InternalErrorException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];

        $result = Flight::multivalue($result, "major");
        $result = Flight::multivalue($result, "minor");
        $result = Flight::multivalue($result, "concentration");
        $result = Flight::multivalue($result, "courses_taken");
        
        return $result;
    }


    // End point 13 - Set Major, Minor and Concentration
    public static function SetMajorMinorConcentration($major, $minor, $concentration)
    {
        self::AuthenticateSession();

        $user_id = $_SESSION['user_id'];
        $sql = "CALL `EP13_SetMajorMinorConcentration`('$user_id', '$major', '$minor', '$concentration');";
        $result = Flight::mysql($sql);
        if($result === false){
            $message = Flight::get("mysql_connection")->error;
            if(preg_match("/a foreign key constraint fails/", $message)){
                throw new InvalidIDException("A program ID or concentration name is invalid");
            }else{
                throw new MySQLDatabaseQueryException();
            }
        }

        $result = self::StudentInformation();
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


    //End point 9
    public static function Enroll_Plan($term, $year)
    {
        $currentID = $_SESSION['user_id'];
        $sql = "SELECT `course_id`
                FROM `enrolls`
                WHERE `user_id` = '$currentID' AND `term` = '$term' AND `year` = '$year'";
        $result = Flight::mysql($sql);
        if ($result === false) {
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
}