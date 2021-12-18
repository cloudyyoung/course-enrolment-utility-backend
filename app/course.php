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

        $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`description`, `C`.`credits`
                FROM `course` as `C`
                WHERE `C`.`code` = '$code' AND `C`.`number` = '$number'";

        $result = mysqli_query($con, $sql);
        return $result;



    }


    //extra end points, get all courses
    public static function AllCourses($con)
    {
      $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`description`, `C`.`credits` FROM `course` as `C`";


      $result = mysqli_query($con, $sql);
      return $result;
    }

    //extra end points, get all courses that has the same code
    public static function CoursesCode ($code, $con)
    {

        $sql = "SELECT `C`.`course_id`, `C`.`no_gpa`, `C`.`repeat`, `C`.`code`, `C`.`number`, `C`.`units`, `C`.`topic`, `C`.`notes`, `C`.`description`, `C`.`credits` FROM `course` as `C`
                WHERE `C`.`code` = '$code' ";

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
