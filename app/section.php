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

        $sql = "SELECT `S`.`course_id`, `S`.`term`, `S`.`year`, `S`.`name`, `S`.`time`, `S`.`note`, `S`.`room`, `I`.`name`
        FROM `section` as `S`, `teaches` as `T`, `instructor` as `I`, `course` as `C`
        WHERE 
        `I`.`instructor_id` = `T`.`instructor_id` AND 
        `S`.`course_id` = `T`.`course_id` AND `T`.`Term` = `S`.`Term` AND `T`.`year` = `S`.`year` AND `T`.`name` = `S`.`name` AND
        `C`.`code` = `S`.`code` AND `C`.`number` = `S`.`number` AND `C`.`course_id` = '$course_id' AND
        `S`.`Term` = '$term' AND `S`.`year` = '$year'" ;
        $result = mysqli_query($con, $sql);
        return $result;
    
    }

}