<?php

namespace App;

use Flight;
use App\NotFoundException;
use App\MySQLDatabaseQueryException;

class Program extends Contactable
{
    //Extra end point for End point 12
    public static function AllProgram()
    {

        $sql = "CALL `EP12.1_AllProgram`();";

        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    
    // End point 12
    public static function ProgramInformation($Program_ID)
    {

        $sql = "CALL `EP12.2_ProgramInformation`('$Program_ID');";

        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }else if ($result->num_rows == 0) {
            throw new NotFoundException("Program not found");
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = self::Contactable($result);
        $result = $result[0];
        return $result;
    }
}