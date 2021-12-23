<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;

class Section
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
            $section = Flight::multivalue($section, "instructor");
        }
        
        return $result;
    }
}
