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

        $sql = "SELECT *
                FROM `course` as `C`
                WHERE `C`.`code` = '$code' AND `C`.`number` = '$number'";

        $sql1 = " SELECT `H`.`hours`
                  FROM `hours` as `H`, `course` as `C`
                  WHERE `C`.`course_id` = `H`.`course_id` AND 
                        `C`.`code` = '$code' AND `C`.`number` = '$number'";
        
        $sql2 = " SELECT `A`.`aka`
                  FROM `course_aka` as `A`, `course` as `C`
                  WHERE `C`.`course_id` = `A`.`course_id` AND 
                        `C`.`code` = '$code' AND `C`.`number` = '$number'";

        $sql3 = " SELECT `T`.`time_length`
                  FROM `time_length` as `T`, `course` as `C`
                  WHERE `C`.`course_id` = `T`.`course_id` AND 
                        `C`.`code` = '$code' AND `C`.`number` = '$number'";


        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);

        if (!$result || !$result1 || !$result2 || !$result3)
        {
          return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);

        $result["hours"] = [];
        $result["aka"] = [];
        $result["time_length"] = [];

        foreach ($result1 as &$insert)
        {
          array_push($result["hours"], $insert["hours"]);
        }


        foreach ($result2 as &$insert)
        {
          array_push($result["aka"], $insert["aka"]);
        }


        foreach ($result3 as &$insert)
        {
          array_push($result["time_length"], $insert["time_length"]);
        }
        return $result;



    }


    //extra end points, get all courses
    public static function AllCourses($con)
    {
        $sql = "SELECT *
                FROM `course` as `C`";

        /*$sql1 = " SELECT `H`.`hours`
                  FROM `hours` as `H`, `course` as `C`
                  WHERE `C`.`course_id` = `H`.`course_id`";
        
        $sql2 = " SELECT `A`.`aka`
                  FROM `AKA` as `A`, `course` as `C`
                  WHERE `C`.`course_id` = `A`.`course_id`";

        $sql3 = " SELECT `T`.`time_length`
                  FROM `time_length` as `T`, `course` as `C`
                  WHERE `C`.`course_id` = `T`.`course_id`";*/


        $result = mysqli_query($con, $sql);
        /*
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);*/

        if (!$result)
        {
          return false;
        }
        
        $result = $result->fetch_all(MYSQLI_ASSOC);
        /*
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);

        $result["hours"] = [];
        $result["aka"] = [];
        $result["time_length"] = [];

        foreach ($result1 as &$insert)
        {
          array_push($result["hours"], $insert["hours"]);
        }


        foreach ($result2 as &$insert)
        {
          array_push($result["aka"], $insert["aka"]);
        }


        foreach ($result3 as &$insert)
        {
          array_push($result["time_length"], $insert["time_length"]);
        }*/
        return $result;

    }

    //extra end points, get all courses that has the same code
    public static function CoursesCode ($code, $con)
    {

        $sql = "SELECT *
                FROM `course` as `C` WHERE `C`.`code` = '$code'";
/*
        $sql1 = " SELECT `H`.`hours`
                  FROM `hours` as `H`, `course` as `C`
                  WHERE `C`.`course_id` = `H`.`course_id` WHERE `C`.`code` = '$code'";
        
        $sql2 = " SELECT `A`.`aka`
                  FROM `AKA` as `A`, `course` as `C`
                  WHERE `C`.`course_id` = `A`.`course_id` WHERE `C`.`code` = '$code'";

        $sql3 = " SELECT `T`.`time_length`
                  FROM `time_length` as `T`, `course` as `C`
                  WHERE `C`.`course_id` = `T`.`course_id` WHERE `C`.`code` = '$code'";*/


        $result = mysqli_query($con, $sql);
        /*
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);*/
        
        if (!$result)
        {
          return false;
        }
        /*
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);

        $result["hours"] = [];
        $result["aka"] = [];
        $result["time_length"] = [];

        foreach ($result1 as &$insert)
        {
          array_push($result["hours"], $insert["hours"]);
        }


        foreach ($result2 as &$insert)
        {
          array_push($result["aka"], $insert["aka"]);
        }


        foreach ($result3 as &$insert)
        {
          array_push($result["time_length"], $insert["time_length"]);
        }*/
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;


    }


    public static function Course_Information_CID ($course_id, $con)
    {
        $sql = "SELECT *
                FROM `course` as `C`
                WHERE `C`.`course_id` = '$course_id'";

        $sql1 = " SELECT `H`.`hours`
                  FROM `hours` as `H`
                  WHERE `H`.`course_id` = '$course_id' ";
        
        $sql2 = " SELECT `A`.`aka`
                  FROM `course_aka` as `A`
                  WHERE `A`.`course_id` = '$course_id'";

        $sql3 = " SELECT `T`.`time_length`
                  FROM `time_length` as `T`
                  WHERE `T`.`course_id` = '$course_id'";
      

      $result = mysqli_query($con, $sql);
      $result1 = mysqli_query($con, $sql1);
      $result2 = mysqli_query($con, $sql2);
      $result3 = mysqli_query($con, $sql3);

      if (!$result || !$result1 || !$result2 || !$result3)
      {
        return false;
      }

      $result = $result->fetch_all(MYSQLI_ASSOC);
      $result = $result[0];
      $result1 = $result1->fetch_all(MYSQLI_ASSOC);
      $result2 = $result2->fetch_all(MYSQLI_ASSOC);
      $result3 = $result3->fetch_all(MYSQLI_ASSOC);

      $result["hours"] = [];
      $result["aka"] = [];
      $result["time_length"] = [];

      foreach ($result1 as &$insert)
      {
        array_push($result["hours"], $insert["hours"]);
      }


      foreach ($result2 as &$insert)
      {
        array_push($result["aka"], $insert["aka"]);
      }


      foreach ($result3 as &$insert)
      {
        array_push($result["time_length"], $insert["time_length"]);
      }
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
