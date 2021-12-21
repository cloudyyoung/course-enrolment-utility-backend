<?php

namespace App;

use Flight;

//aka --> contractable
//AKA --> course_Id
require 'vendor/autoload.php';
class Course
{
  private static function ParseArray($array, $key, $type){
    $val = $array[$key];
    if($val == null) return $array;
    if ($val == "null") {
      $array[$key] = null;
      return $array;
    }
    
    $arr = explode(",", $val);
    $val2 = [];
    foreach($arr as $a){
      if($a == "null"){
        $a = null;
      }else{
        $val2[] = $type($a);
      }
    }
    
    $array[$key] = $val2;
    return $array;
  }


  //End point 5.3 - course code and number
  public static function CourseCodeNumber($code, $number)
  {

    $sql = "CALL `EP5.3_CourseCodeNumber`('$code', $number);";
    $result = Flight::mysql($sql);
    if($result === false){
      throw new MySQLDatabaseQueryException();
    }else if($result->num_rows == 0){
      throw new NotFoundException("Course not found");
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    $result = $result[0];
    $result = self::ParseArray($result, "aka", "strval");
    $result = self::ParseArray($result, "hours", "strval");
    $result = self::ParseArray($result, "time_length", "strval");

    $course_key = strtoupper($code) . " " . $number;

    $cursor = Flight::mongo(array('key' => $course_key));
    $requisite = $cursor->toArray();
    if(count($requisite) == 0){
      throw new NotFoundException("Course not found");
    }

    $requisite = $requisite[0];
    $result["prerequisite_array"] = json_decode($requisite["prerequisite"]);
    $result["antirequisite_array"] = json_decode($requisite["antirequisite"]);
    $result["corequisite_array"] = json_decode($requisite["corequisite"]);

    return $result;
  }


  // End point 5.1 - all courses
  public static function AllCourses()
  {
    $sql = "CALL `EP5.1_AllCourses`();";
    $result = Flight::mysql($sql);
    if (!$result) {
      throw new MySQLDatabaseQueryException();
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    return $result;
  }

  // End point 5.2 - all courses with given code
  public static function CoursesCode($code)
  {
    $sql = "CALL `EP5.2_CoursesCode`('$code');";
    $result = Flight::mysql($sql);
    if (!$result) {
      throw new MySQLDatabaseQueryException();
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
    } else if ($result->num_rows == 0) {
      return null;
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
