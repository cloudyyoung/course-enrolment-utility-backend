<?php

namespace App;

use Flight;

//aka --> contractable
//AKA --> course_Id
require 'vendor/autoload.php';
class Course
{
  //End point 5
  //Don;t forget to add the mongoDB part 
  public static function CourseInformation($code, $number)
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


    $result = Flight::mysql($sql);
    $result1 = Flight::mysql($sql1);
    $result2 = Flight::mysql($sql2);
    $result3 = Flight::mysql($sql3);

    if (!$result || !$result1 || !$result2 || !$result3) {
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

    foreach ($result1 as &$insert) {
      array_push($result["hours"], $insert["hours"]);
    }


    foreach ($result2 as &$insert) {
      array_push($result["aka"], $insert["aka"]);
    }


    foreach ($result3 as &$insert) {
      array_push($result["time_length"], $insert["time_length"]);
    }


    $key = $code . " " . $number;

    //get the data from mongodb
    $client = new \MongoDB\Client(
      'mongodb+srv://ucalgary:ureqIynl0ZMm0GGr@cluster0.yoz3k.mongodb.net/myFirstDatabase?retryWrites=true&w=majority'
    );
    $database = $client->requisite;
    $collection = $database->CPSC;
    $cursor = $collection->find(array('key' => $key));
    $requisite = $cursor->toArray()[0];

    $result["prereq"] = json_decode($requisite["prerequisite"]);
    $result["antireq"] = json_decode($requisite["antirequisite"]);
    $result["coreq"] = json_decode($requisite["corequisite"]);

    return $result;
  }


  //extra end points, get all courses
  public static function AllCourses()
  {
    $sql = "SELECT *
                FROM `course` as `C`";

    $result = Flight::mysql($sql);

    if (!$result) {
      return false;
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    return $result;
  }

  //extra end points, get all courses that has the same code
  public static function CoursesCode($code)
  {

    $sql = "SELECT *
                FROM `course` as `C` WHERE `C`.`code` = '$code'";

    $result = Flight::mysql($sql);
    if (!$result) {
      return false;
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    return $result;
  }


  public static function CourseInformation_CID($course_id)
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


    $result = Flight::mysql($sql);
    $result1 = Flight::mysql($sql1);
    $result2 = Flight::mysql($sql2);
    $result3 = Flight::mysql($sql3);

    if (!$result || !$result1 || !$result2 || !$result3) {
      return false;
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    if (count($result) == 0) {
      return null;
    }

    $result = $result[0];
    $result1 = $result1->fetch_all(MYSQLI_ASSOC);
    $result2 = $result2->fetch_all(MYSQLI_ASSOC);
    $result3 = $result3->fetch_all(MYSQLI_ASSOC);

    $result["hours"] = [];
    $result["aka"] = [];
    $result["time_length"] = [];

    foreach ($result1 as &$insert) {
      array_push($result["hours"], $insert["hours"]);
    }


    foreach ($result2 as &$insert) {
      array_push($result["aka"], $insert["aka"]);
    }


    foreach ($result3 as &$insert) {
      array_push($result["time_length"], $insert["time_length"]);
    }


    //get code and number of the course
    $sql = "SELECT `code`,`number`
              FROM `course`
              WHERE `course_id` = '$course_id'";

    $CodeAndNumber = Flight::mysql($sql);
    $CodeAndNumber = $CodeAndNumber->fetch_all(MYSQLI_ASSOC);
    $CodeAndNumber = $CodeAndNumber[0];

    //create the course name with code and number 
    $key = $CodeAndNumber['code'] . " " . $CodeAndNumber['number'];

    //get the data from mongodb
    $client = new \MongoDB\Client(
      'mongodb+srv://ucalgary:ureqIynl0ZMm0GGr@cluster0.yoz3k.mongodb.net/myFirstDatabase?retryWrites=true&w=majority'
    );
    $database = $client->requisite;
    $collection = $database->CPSC;
    $cursor = $collection->find(array('key' => $key));
    $requisite = $cursor->toArray()[0];

    $result["prereq"] = json_decode($requisite["prerequisite"]);
    $result["antireq"] = json_decode($requisite["antirequisite"]);
    $result["coreq"] = json_decode($requisite["corequisite"]);

    return $result;
  }
}
