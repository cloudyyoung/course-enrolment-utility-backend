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
    public static function Section_Information($code, $number, $term, $year, $con)
    {

        $sql = "SELECT * FROM `section` NATURAL JOIN `teaches` NATURAL JOIN `course` NATURAL JOIN `instructor` 
                WHERE `code`='$code' AND `number`=$number AND `term`='$term' AND `year`=$year ";

        $result = mysqli_query($con, $sql);
        return $result;
    
    }

}