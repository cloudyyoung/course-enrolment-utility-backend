<?php

namespace App;

use Flight;

class Contactable {
    public static function Contactable($result){
        foreach ($result as &$row) {
            // Handle multiple value array
            $row = Flight::multivalue($row, "aka", "strval");
            $row = Flight::multivalue($row, "phone", "strval");
            $row = Flight::multivalue($row, "website", "strval");
            $row = Flight::multivalue($row, "room", "strval");
            $row = Flight::multivalue($row, "email", "strval");
        }

        return $result;
    }
}