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
        $code = strtoupper($code);
        $sql = "SELECT `course_id`, `term`, `year`, `name`, `time`, `note`, `room` FROM `section` NATURAL JOIN `course`
                WHERE `code`='$code' AND `number`=$number AND `term`='$term' AND `year`=$year ";
        $result = mysqli_query($con, $sql);
        
        if(!$result)
        {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);

        $result_out = [];
        foreach($result as &$row){
            $name = $row["name"];
            $sql1 = "SELECT `instructor_id`, `name` FROM `section` NATURAL JOIN `teaches` NATURAL JOIN `course` NATURAL JOIN `instructor` 
                WHERE `code`='$code' AND `number`=$number AND `term`='$term' AND `year`=$year AND `name` = '$name' ";
            $result1 = mysqli_query($con, $sql1);
            $result1 = $result1->fetch_all(MYSQLI_ASSOC);

            $row["instructor"] = $result1;
            array_push($result_out, $row);
        }

        return $result_out;
    }

}