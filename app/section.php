<?php

namespace App;

class section 
{
    public function __construct($object)
    {
        
    }

    //INCOMPLETE, WILL DO LATER
    //Code and number is used for the primary key of the table course.
    //End point 6
    public static function Section_Information ($course_id, $term, $year, $con)
    {

        $sql = "SELECT `S`.`Course_ID`, `S`.`Term`, `S`.`Year`, `S`.`Name`, `S`.`Time`, `S`.`Note`, `S`.`Room`, `I`.`Name`
        FROM `SECTION` as `S,` `TEACHES` as `T,` `INSTRUCTOR` as `I`, `COURSE` as `C`
        WHERE 
        `I`.`Instructor_ID` = `T`.`Instructor_ID` AND 
        `S`.`Course_ID` = `T`.`Course_ID` AND `T`.`Term` = `S`.`Term` AND `T`.`Year` = `S`.`Year` AND `T`.`Name` = `S`.`Name` AND
        `C`.`Code` = `S`.`Code` AND `C`.`Number` = `S`.`Number` AND `C`.`course_id` = '$course_id' AND
        `S`.`Term` = '$term' AND `S`.`Year` = '$year'" ;
        $result = mysqli_query($con, $sql);
        return $result;
    
    }

}