<?php

namespace App;

use Flight;

class Faculty extends Contactable
{
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
