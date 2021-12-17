<?php

namespace App;


//aka --> contractable
//AKA --> course_Id
/*
 *DONT FORGET TO CHANGE THE TABLE NAME AND ATTRIBUTES TO MATCH THE MYSQL DATABASE
 */

class Faculty 
{
    public function __construct($object)
    {
        
    }

    //End point 7
    public static function Faculty_Information($faculty_id,  $con)
    {
        $sql = "SELECT `F`.`faculty_id`, `F`.`name`, `F`.`code`, `F`.`contactable_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `faculty` as `F`, `aka` as `A`, `phone` AS `P`, `website` as `W`, `room(contactable),` as `R`, `email` AS `E`
                WHERE `F`.`contactable_id` = `A.contactable_id` AND
                `F`.`contactable_id` = `P`.`contactable_id` AND
                `F`.`contactable_id` = `W`.`contactable_id` AND
                `F`.`contactable_id` = `R`.`contactable_id` AND
                `F`.`contactable_id` = `E`.`contactable_id` AND
                `F`.`faculty_id` = '$faculty_id'";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //extra end point for end point 7
    public static function AllFaculty($con)
    {
        $sql = "SELECT `F`.`faculty_id`, `F`.`name`, `F`.`code`, `F`.`contactable_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `faculty` as `F`, `aka` as `A`, `phone` AS `P`, `website` as `W`, `room(contactable),` as `R`, `email` AS `E`
                WHERE `F`.`contactable_id` = `A.contactable_id` AND
                `F`.`contactable_id` = `P`.`contactable_id` AND
                `F`.`contactable_id` = `W`.`contactable_id` AND
                `F`.`contactable_id` = `R`.`contactable_id` AND
                `F`.`contactable_id` = `E`.`contactable_id`";
        $result = mysqli_query($con, $sql);
        return $result;
    }    


    //End point 8
    public static function Department_Information($department_id, $con)
    {
        $sql = "SELECT `D`.`department_id`, `D`.`name`, `D`.`code`, `D`.`faculty_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `department` as `D`, `aka` as `A`, `phone` AS `P`, `website` as `W`, `room(contactable)` as `R`, `email` AS `E`
                WHERE `D`.`contactable_id` = `A`.`contactable_id` AND
                `D`.`contactable_id` = `P`.`contactable_id` AND
                `D`.`contactable_id` = `W`.`contactable_id` AND
                `D`.`contactable_id` = `R`.`contactable_id` AND
                `D`.`contactable_id` = `E`.`contactable_id` AND
                `D`.`department_id` = '$department_id'";
        $result = mysqli_query($con, $sql);
        return $result;
        
    }

    //Extra end for end point 8
    public static function AllDepartment($con)
    {
        $sql = "SELECT `D`.`department_id`, `D`.`name`, `D`.`code`, `D`.`faculty_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `department` as `D`, `aka` as `A`, `phone` AS `P`, `website` as `W`, `room(contactable)` as `R`, `email` AS `E`
                WHERE `D`.`contactable_id` = `A`.`contactable_id` AND
                `D`.`contactable_id` = `P`.`contactable_id` AND
                `D`.`contactable_id` = `W`.`contactable_id` AND
                `D`.`contactable_id` = `R`.`contactable_id` AND
                `D`.`contactable_id` = `E`.`contactable_id`";
        $result = mysqli_query($con, $sql);
        return $result;
        
    }    


    //End point 4
    public static function Instructor_Information($Instructor_id, $con)
    {

        $sql =" SELECT `I`.`instructor_id`, `I`.`name`, `I`.`department_id`, `T`.`title`, `P`.`phones`, `R`.`room`
                FROM `instructor` as `I`, `title` as `T`, phones as P, room as R
                WHERE `I`.`instructor_id` = `T`.`instructor_id` AND
                `I`.`instructor_id` = `P`.`instructor_id` AND
                `I`.`instructor_id` = `R`.`instructor_id` AND
                `I`.`instructor_id` = '$Instructor_id'";
        $result = mysqli_query($con, $sql);
        return $result;
    }




    //End point 12
    public static function Program_Information($Program_ID, $con)
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `program` AS `P,` `aka` as `A`, `phone` AS `P`, `website` as `W`, `room` as `R`, `email` as `E`
                WHERE `P`.`contactable_id` = `A`.`contactable_id` AND
                `P`.`contactable_id` = `P`.`contactable_id` AND
                `P`.`contactable_id` = `W`.`contactable_id` AND
                `P`.`contactable_id` = `R`.`contactable_id` AND
                `P`.`contactable_id` = `E`.`contactable_id` AND
                `P`.`program_id` = '$Program_ID'";

        $result = mysqli_query($con, $sql);
        return $result;
    }

    //Extra end point for End point 12
    public static function AllProgram($con)
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`, `A`.`aka`, `P`.`phone`, `W`.`website`, `R`.`room`, `E`.`email`
                FROM `program` AS `P,` `aka` as `A`, `phone` AS `P`, `website` as `W`, `room` as `R`, `email` as `E`
                WHERE `P`.`contactable_id` = `A`.`contactable_id` AND
                `P`.`contactable_id` = `P`.`contactable_id` AND
                `P`.`contactable_id` = `W`.`contactable_id` AND
                `P`.`contactable_id` = `R`.`contactable_id` AND
                `P`.`contactable_id` = `E`.`contactable_id`";

        $result = mysqli_query($con, $sql);
        return $result;
    }







    //End point 11
   public static function ConcentrationForProgram($Program_ID,$con)
   {


       $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
               FROM `concentration` as `C`
               WHERE `C`.`program_id` = '$Program_ID'";
       $result = mysqli_query($con, $sql);
       return $result;
   }


    //Extra end point for end point 11
    public static function AllConcentration($con)
    {


        $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
                FROM `concentration` as `C`";
        $result = mysqli_query($con, $sql);
        return $result;
    }


    //End point 2
    public static function Account_Signup($email, $password, $con)
    {                                                            
        $sql = "INSERT INTO `user` (`email`, `password`) VALUES ('$email','$password')";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //End point 9
    public static function Enroll_Plan($term, $year, $con)
    {

        $sql = "SELECT `C`.`code`, `C`.`number`
                FROM `course` as `C`, `section` as `C`
                WHERE `C`.`code` = `S`.`code` AND `C`.`number` = `S`.`number` AND
                `S`.`year` = '$year' AND `S`.`term` = '$term'";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //End point 15
    public static function View_Stat($con)
    {

        $sql = "SELECT COUNT(*)
                FROM `user`";
        $result = mysqli_query($con, $sql);
        return $result;                
    }



}