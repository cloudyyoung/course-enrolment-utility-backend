<?php

namespace App;

use Flight;
use App\NotFoundException;
use App\MySQLDatabaseQueryException;

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
        }else if ($result->num_rows == 0) {
            throw new NotFoundException("Faculty not found");
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = self::Contactable($result);
        $result = $result[0];
        return $result;
    }
}
