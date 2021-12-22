<?php

namespace App;

use Flight;
use App\UnauthorizedAccessException;
use App\NotFoundException;
use App\MySQLDatabaseQueryException;

class Admin extends Account {
    protected static function AuthenticateSession(){
        parent::AuthenticateSession();

        if($_SESSION['type'] != 'admin'){
            throw new UnauthorizedAccessException("Only administrators can access this endpoint");
        }
    }

    
    // End point 16 - Website Statistics
    public static function WebsiteStatistics() {
        self::AuthenticateSession();

        $sql = "CALL `EP16_WebsiteStatistics`();";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }else if($result->num_rows == 0){
            throw new InternalErrorException("No statistics is available at this time");
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        return $result;
    }
}