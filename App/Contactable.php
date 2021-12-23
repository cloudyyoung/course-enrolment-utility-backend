<?php

namespace App;

use Flight;

class Contactable {
    public static function Contactable($result){
        foreach ($result as &$row) {
            // Handle multiple value array
            $row = Flight::multivalue($row, "aka");
            $row = Flight::multivalue($row, "phone");
            $row = Flight::multivalue($row, "website");
            $row = Flight::multivalue($row, "room");
            $row = Flight::multivalue($row, "email");
        }

        return $result;
    }
}