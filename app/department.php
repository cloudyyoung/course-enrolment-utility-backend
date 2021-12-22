<?php

namespace App;

use Flight;
use App\NotFoundException;
use App\MySQLDatabaseQueryException;

class Department extends Contactable {

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
        }else if ($result->num_rows == 0) {
            throw new NotFoundException("Department not found");
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = self::Contactable($result);

        return $result;
    }
}
