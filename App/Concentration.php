<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;

class Concentration
{
    // End point 11.1 - All Concentration
    public static function AllConcentration()
    {
        $sql = "CALL `EP11.1_AllConcentration`();";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    // End point 11.2 - Concentration Information by Program ID
    public static function ConcentrationForProgram($program_id)
    {
        // Check if program_id is valid
        Program::ProgramInformation($program_id);

        $sql = "CALL `EP11.2_ConcentrationForProgram`('$program_id');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
}