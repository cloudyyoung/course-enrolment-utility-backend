<?php

namespace App;

use Flight;

//aka --> contractable
//AKA --> course_Id
/*
 *DONT FORGET TO CHANGE THE TABLE NAME AND ATTRIBUTES TO MATCH THE MYSQL DATABASE
 */

class Faculty extends Contactable
{
    private static function process_info_contactable($result, $result1, $result2, $result3, $result4, $result5)
    {
        //if one of them is incorrect then return false
        if (!$result || !$result1 || !$result2 || !$result3 || !$result4 || !$result5) {
            return false;
        }

        //transform the result into readable formats
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);
        $result4 = $result4->fetch_all(MYSQLI_ASSOC);
        $result5 = $result5->fetch_all(MYSQLI_ASSOC);

        //transform the result from other results into result
        $result["aka"] = [];
        $result["phone"] = [];
        $result["website"] = [];
        $result["room"] = [];
        $result["email"] = [];


        foreach ($result1 as &$insert) {
            array_push($result["aka"], $insert["aka"]);
        }


        foreach ($result2 as &$insert) {
            array_push($result["phone"], $insert["phone"]);
        }


        foreach ($result3 as &$insert) {
            array_push($result["website"], $insert["website"]);
        }


        foreach ($result4 as &$insert) {
            array_push($result["room"], $insert["room"]);
        }

        foreach ($result5 as &$insert) {
            array_push($result["email"], $insert["email"]);
        }

        return $result;
    }


    // End point 7.1 - All faculty
    public static function AllFaculty()
    {
        $sql = "CALL `EP7.1_AllFaculty`();";
        $result = Flight::mysql($sql);

        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    //End point 7.2 - Faculty Information by Faculty ID
    public static function FacultyInformation($faculty_id)
    {
        $sql = "CALL `EP7.2_FacultyInformation`('$faculty_id');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = self::Contactable($result);

        return $result;
    }




    //End point 11
    public static function ConcentrationForProgram($Program_ID)
    {


        $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
               FROM `concentration` AS `C`
               WHERE `C`.`program_id` = '$Program_ID'";
        $result = Flight::mysql($sql);
        if ($result === false) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    //Extra end point for end point 11
    public static function AllConcentration()
    {
        $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
                FROM `concentration` AS `C`";
        $result = Flight::mysql($sql);
        if ($result === false) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}
