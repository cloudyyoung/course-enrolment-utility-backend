<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;

class Instructor {
    public static function InstructorInformation($instructor_id) {
        $sql = "CALL `EP4_InstructorInformation`('$instructor_id');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        } else if ($result->num_rows == 0) {
            throw new NotFoundException("Instructor not found");
        }
        
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];

        $result = Flight::multivalue($result, "title", "strval");
        $result = Flight::multivalue($result, "phone", "strval");
        $result = Flight::multivalue($result, "room", "strval");
        
        return $result;
    }
}