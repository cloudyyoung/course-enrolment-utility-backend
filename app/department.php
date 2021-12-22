<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;

class Department {

    // End point 8.1 - All departments
    public static function AllDepartment()
    {
        $sql = "CALL `EP8.1_AllDepartment`();";
        $result = Flight::mysql($sql);

        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }

    
    // End point 8.2 - Department Information by Department ID
    public static function DepartmentInformation($department_id)
    {
        $sql = "CALL `EP8.2_DepartmentInformation`('$department_id');";
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
}
