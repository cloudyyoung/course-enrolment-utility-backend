<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;

class section
{
    // End point 6 - Section Information
    public static function SectionInformation($code, $number, $term, $year)
    {
        $code = strtoupper($code);
        $sql = "CALL `EP6_SectionInformation`('$code', '$number', '$term', '$year');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);

        foreach($result as &$section){
            $section = Flight::multivalue($section, "instructor_name", "strval");
            $section = Flight::multivalue($section, "instructor_id", "intval");

            $section["instructor"] = [];
            foreach($section["instructor_name"] as $key => $value){
                $section["instructor"][] = [
                    "name" => $value,
                    "id" => $section["instructor_id"][$key]
                ];
            }

            unset($section["instructor_name"]);
            unset($section["instructor_id"]);
        }
        
        return $result;
    }
}
