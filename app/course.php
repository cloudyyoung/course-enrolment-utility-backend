<?php

namespace App;

//aka --> contractable
//AKA --> course_Id

class course 
{

    public function __construct($object)
    {
        
    }

    //End point 5
    //Don;t forget to add the mongoDB part 
    public static function Course_Information ($code,$number, $con)
    {

        $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`descrption`, `C`.`credit`, `H`.`hours`, `A`.`aka`, `T`.`time_length`
                FROM `course` as `C`, `hours` as `H`, `AKA` as `A`, `time_length` as `T`
                WHERE `C`.`course_id` = `H`.`course_id AND
                `C`.`course_id` = `A`.`course_id` AND
                `C`.`course_id` = `T`.`course_id` AND
                `C`.`code` = '$code' AND `C`.`number` = '$number'";

        $result = mysqli_query($con, $sql);
        return $result;



    }


    //extra end points, get all courses
    public static function AllCourses($con)
    {
      $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`descrption`, `C`.`credit`, `H`.`hours`, `A`.`aka`, `T`.`time_length`
      FROM `course` as `C`, `hours` as `H`, `AKA` as `A`, `time_length` as `T`
      WHERE `C`.`course_id` = `H`.`course_id AND
      `C`.`course_id` = `A`.`course_id` AND
      `C`.`course_id` = `T`.`course_id`";

      $result = mysqli_query($con, $sql);
      return $result;
    }

    //extra end points, get all courses that has the same code
    public static function CoursesCode ($code, $con)
    {

        $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`descrption`, `C`.`credit`, `H`.`hours`, `A`.`aka`, `T`.`time_length`
                FROM `course` as `C`, `hours` as `H`, `AKA` as `A`, `time_length` as `T`
                WHERE `C`.`course_id` = `H`.`course_id AND
                `C`.`course_id` = `A`.`course_id` AND
                `C`.`course_id` = `T`.`course_id` AND
                `C`.`code` = '$code' ";

        $result = mysqli_query($con, $sql);
        return $result;



    }

}
/*
// Database connection 
 // larp-cloud 
 $client = new MongoDB\Client( 
 'mongodb+srv://ucalgary:<password>@cluster0.yoz3k.mongodb.net/myFirstDatabase?retryWrites=true&w=majority' 
 ); 
   $larp_db = $client->larp; 
 Flight::set("larp_db", $larp_db); 

*/
