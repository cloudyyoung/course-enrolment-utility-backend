<?php

namespace App;

use Flight;
use App\NotFoundException;
use App\MySQLDatabaseQueryException;


class Course
{

  private static function mongoDBCourse($result, $course_key = null)
  {
    //if we want a specific course
    if ($course_key != null) {
      $cursor = Flight::mongo(array('key' => $course_key));
      $requisite = $cursor->toArray();
      if (count($requisite) == 0) {
        throw new NotFoundException("Course not found");
      }

      $requisite = $requisite[0];
      $result["prerequisite_array"] = json_decode($requisite["prerequisite"]);
      $result["antirequisite_array"] = json_decode($requisite["antirequisite"]);
      $result["corequisite_array"] = json_decode($requisite["corequisite"]);

      return $result;
    }

    //if we want all courses
    else {
      $cursor = Flight::mongo(array());
      $requisite = $cursor->toArray();
      if (count($requisite) == 0) {
        throw new NotFoundException("Course not found");
      }

      $dictionary = array();

      //put all the information in a hash table, course id --> information
      foreach ($requisite as &$insert)
      {
        $insert["prerequisite"] = json_decode($insert["prerequisite"]);
        $insert["antirequisite"] = json_decode($insert["antirequisite"]);
        $insert["corequisite"] = json_decode($insert["corequisite"]);
        $dictionary[$insert["key"]] = $insert;
      }

      //loop through each courses
      foreach ($result as &$course) {
        $code = $course["code"];;
        $number = $course["number"];
        $search = strtoupper($code) . " " . $number;

        //add each course's requisite to the result array
        $course["prerequisite_array"]=$dictionary[$search]["prerequisite"];
        $course["antirequisite_array"]=$dictionary[$search]["antirequisite"];
        $course["corequisite_array"]=$dictionary[$search]["corequisite"];
      }

      return $result;
    }
  }

  
  // End point 5.1 - All Courses
  public static function AllCourses()
  {
    $sql = "CALL `EP5.1_AllCourses`();";
    $result = Flight::mysql($sql);
    if ($result === false) {
      throw new MySQLDatabaseQueryException();
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    $result = course::mongoDBCourse($result);
    return $result;
  }


  // End point 5.2 - Courses Information by Course Code
  public static function CoursesCode($code)
  {
    $sql = "CALL `EP5.2_CoursesCode`('$code');";
    $result = Flight::mysql($sql);
    if ($result === false) {
      throw new MySQLDatabaseQueryException();
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    $result = course::mongoDBCourse($result);
    return $result;    
  }


  // End point 5.3 - Course Information by Course Key
  public static function CourseCodeNumber($code, $number)
  {

    $sql = "CALL `EP5.3_CourseCodeNumber`('$code', $number);";
    $result = Flight::mysql($sql);
    if ($result === false) {
      throw new MySQLDatabaseQueryException();
    } else if ($result->num_rows == 0) {
      throw new NotFoundException("Course not found");
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    $result = $result[0];
    $result = Flight::multivalue($result, "aka");
    $result = Flight::multivalue($result, "hours");
    $result = Flight::multivalue($result, "time_length");

    $course_key = strtoupper($code) . " " . $number;
    $result = self::mongoDBCourse($result, $course_key);
    return $result;
  }


  // EP5.4 - Course Information by Course ID
  public static function CourseInformation_CID($course_id)
  {
    $sql = "CALL `EP5.4_CourseId`($course_id);";

    $result = Flight::mysql($sql);

    if ($result === false) {
      throw new MySQLDatabaseQueryException();
    } else if ($result->num_rows == 0) {
      throw new NotFoundException("Course not found");
    }

    $result = $result->fetch_all(MYSQLI_ASSOC);
    $result = $result[0];

    $result = Flight::multivalue($result, "hours");
    $result = Flight::multivalue($result, "aka");
    $result = Flight::multivalue($result, "time_length");

    //create the course name with code and number 
    $course_key = strtoupper($result['code']) . " " . $result['number'];
    $result = self::mongoDBCourse($result, $course_key);
    return $result;
  }
}
