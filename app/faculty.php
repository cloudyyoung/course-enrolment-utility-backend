<?php

namespace App;

use Flight;

//aka --> contractable
//AKA --> course_Id
/*
 *DONT FORGET TO CHANGE THE TABLE NAME AND ATTRIBUTES TO MATCH THE MYSQL DATABASE
 */

class Faculty
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

    //End point 7.2 - Faculty Information by Faculty ID
    public static function FacultyInformation($faculty_id)
    {
        $sql = "CALL `EP7.2_FacultyInformation`('$faculty_id');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        foreach ($result as &$faculty) {
            // Handle multiple value array
            $faculty = Flight::multivalue($faculty, "aka", "strval");
            $faculty = Flight::multivalue($faculty, "phone", "strval");
            $faculty = Flight::multivalue($faculty, "website", "strval");
            $faculty = Flight::multivalue($faculty, "room", "strval");
            $faculty = Flight::multivalue($faculty, "email", "strval");
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



    //End point 8
    public static function DepartmentInformation($department_id)
    {
        $sql = "SELECT *
                FROM `department` AS `D`
                WHERE `D`.`department_id` = '$department_id'";

        $sql1 = "   SELECT `A`.`aka`
                    FROM `aka` AS `A`, `department` AS `D`
                    WHERE `A`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql2 = "   SELECT `P`.`phone`
                    FROM `phone` AS `P`, `department` AS `D`
                    WHERE `P`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql3 = "   SELECT `W`.`website`
                    FROM `website` AS `W`, `department` AS `D`
                    WHERE `W`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql4 = "   SELECT `R`.`room`
                    FROM `room(contactable)` AS `R`, `department` AS `D`
                    WHERE `R`.`contactable_id` = `D`.`contactable_id` AND`D`.`department_id` = '$department_id'";

        $sql5 = "   SELECT `E`.`email`
                    FROM `email` AS `E`, `department` AS `D`
                    WHERE `E`.`email` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";


        //get the result of the query for each components
        $result = Flight::mysql($sql);
        $result1 = Flight::mysql($sql1);
        $result2 = Flight::mysql($sql2);
        $result3 = Flight::mysql($sql3);
        $result4 = Flight::mysql($sql4);
        $result5 = Flight::mysql($sql5);
        return (faculty::process_info_contactable($result, $result1, $result2, $result3, $result4, $result5));
    }



    //Extra end for end point 8
    public static function AllDepartment()
    {
        $sql = "SELECT `D`.`department_id`, `D`.`name`, `D`.`code`, `D`.`faculty_id`
                FROM `department` AS `D`";


        $result = Flight::mysql($sql);

        if ($result === false) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    //End point 12
    public static function ProgramInformation($Program_ID)
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`
                FROM `program` AS `P`
                WHERE `P`.`program_id` = '$Program_ID'";

        $sql1 = "   SELECT `A`.`aka`
                    FROM `aka` AS `A`, `program` AS `Pa`
                    WHERE `A`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql2 = "   SELECT `P`.`phone`
                    FROM `phone` AS `P`, `program` AS `Pa`
                    WHERE `P`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql3 = "   SELECT `W`.`website`
                    FROM website,` AS `W`, `program` AS `Pa`
                    WHERE `W`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql4 = "   SELECT `R`.`room(contactable)`
                    FROM room(contactable),` AS `R`,`program` AS `Pa`
                    WHERE `A`.`contactable_id` = `P`.`contactable_id` AND`Pa`.`program_id` = '$Program_ID'";

        $sql5 = "   SELECT `E`.`email`
                    FROM `email` AS `E`,`program` AS `Pa`
                    WHERE `E`.`email` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $result = Flight::mysql($sql);
        //get the result of the query for each components
        $result = Flight::mysql($sql);
        $result1 = Flight::mysql($sql1);
        $result2 = Flight::mysql($sql2);
        $result3 = Flight::mysql($sql3);
        $result4 = Flight::mysql($sql4);
        $result5 = Flight::mysql($sql5);
        return (faculty::process_info_contactable($result, $result1, $result2, $result3, $result4, $result5));
    }

    //Extra end point for End point 12
    public static function AllProgram()
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`
                FROM `program` AS `P`
                WHERE `P`.`contactable_id` = `E`.`contactable_id`";

        $result = Flight::mysql($sql);
        if ($result === false) {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
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
