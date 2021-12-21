<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;
use App\InternalErrorException;
use App\IncorrectUsernameOrPasswordException;

class Instructor {
    private static function ParseArray($array, $key, $type){
        $val = $array[$key];
        if($val == null) return $array;
        
        $arr = explode(",", $val);
        $val2 = [];
        foreach($arr as $a){
            $val2[] = $type($a);
        }

        $array[$key] = $val2;
        return $array;
    }

    public static function InstructorInformation($instructor_id) {
        $sql = "CALL `EP4_InstructorInformation`('$instructor_id');";
        $result = Flight::mysql($sql);
        if (!$result) {
            throw new MySQLDatabaseQueryException();
        } else if ($result->num_rows == 0) {
            throw new NotFoundException();
        }
        
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];

        $result = self::ParseArray($result, "title", "strval");
        $result = self::ParseArray($result, "phone", "strval");
        $result = self::ParseArray($result, "room", "strval");
        
        return $result;
    }
}