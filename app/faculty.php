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

//FROM `faculty` AS `F`, `aka` AS `A`, `phone` AS `P`, `website` AS `W`, `room(contactable),` AS `R`, `email` AS `E`


    public static function process_info_contactable($result, $result1, $result2, $result3,$result4 ,$result5 )
    {
        //if one of them is incorrect then return false
        if (!$result || !$result1 || !$result2 || !$result3 || !$result4 || !$result5)
        {
          return false;
        }



        //transform the result into readable formats
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);
        $result4 = $result4->fetch_all(MYSQLI_ASSOC);
        $result5 = $result5->fetch_all(MYSQLI_ASSOC);

        //transform the result from other results into result
        $result["aka"] = [];
        $result["phone"] = [];
        $result["website"] = [];
        $result["room"] = [];
        $result["email"] = [];


        foreach ($result1 as &$insert)
        {
          array_push($result["aka"], $insert["aka"]);
        }


        foreach ($result2 as &$insert)
        {
          array_push($result["phone"], $insert["phone"]);
        }


        foreach ($result3 as &$insert)
        {
          array_push($result["website"], $insert["website"]);
        }


        foreach ($result4 as &$insert)
        {
          array_push($result["room"], $insert["room"]);
        }

        foreach ($result5 as &$insert)
        {
          array_push($result["email"], $insert["email"]);
        }

        return $result;
    }

    //End point 7
    public static function Faculty_Information($faculty_id,  $con)
    {
        //get all components
        $sql = "SELECT `F`.`faculty_id`, `F`.`name`, `F`.`code`, `F`.`contactable_id`
                FROM `faculty` AS `F`
                WHERE `F`.`faculty_id` = '$faculty_id'";

        $sql1 = "   SELECT `A`.`aka`
                    FROM `aka` AS `A`, `faculty` AS `F`
                    WHERE `A`.`contactable_id` = `F`.`contactable_id` AND `F`.`faculty_id` = '$faculty_id'";

        $sql2 = "   SELECT `P`.`phone`
                    FROM `phone` AS `P`, `faculty` AS `F`
                    WHERE `P`.`contactable_id` = `F`.`contactable_id` AND `F`.`faculty_id` = '$faculty_id'";

        $sql3 = "   SELECT `W`.`website`
                    FROM `website` AS `W`, `faculty` AS `F`
                    WHERE `W`.`contactable_id` = `F`.`contactable_id` AND `F`.`faculty_id` = '$faculty_id'";

        $sql4 = "   SELECT `R`.`room`
                    FROM `room(contactable)` AS `R`, `faculty` AS `F`
                    WHERE `R`.`contactable_id` = `F`.`contactable_id` AND `F`.`faculty_id` =  '$faculty_id'";

        $sql5 = "   SELECT `E`.`email`
                    FROM `email` AS `E`, `faculty` AS `F`
                    WHERE `E`.`email` = `F`.`contactable_id` AND `F`.`faculty_id` = '$faculty_id'";    
                    
                    
        //get the result of the query for each components
        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);
        $result4 = mysqli_query($con, $sql4);
        $result5 = mysqli_query($con, $sql5);
        return (faculty::process_info_contactable($result, $result1, $result2, $result3,$result4 ,$result5 ));
        
    }

    //extra end point for end point 7
    public static function AllFaculty($con)
    {
        $sql = "SELECT `F`.`faculty_id`, `F`.`name`, `F`.`code`, `F`.`contactable_id`
                FROM `faculty` AS `F`";
        
        $result = mysqli_query($con, $sql);

        if (!$result)
        {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }    



    //End point 8
    public static function Department_Information($department_id, $con)
    {
        $sql = "SELECT *
                FROM `department` AS `D`
                WHERE `D`.`department_id` = '$department_id'";

        $sql1 = "   SELECT `A`.`aka`
                    FROM `aka` AS `A`, `department` AS `D`
                    WHERE `A`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql2 = "   SELECT `P`.`phone`
                    FROM `phone` AS `P`, `department` AS `D`
                    WHERE `P`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql3 = "   SELECT `W`.`website`
                    FROM `website` AS `W`, `department` AS `D`
                    WHERE `W`.`contactable_id` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";

        $sql4 = "   SELECT `R`.`room`
                    FROM `room(contactable)` AS `R`, `department` AS `D`
                    WHERE `R`.`contactable_id` = `D`.`contactable_id` AND`D`.`department_id` = '$department_id'";

        $sql5 = "   SELECT `E`.`email`
                    FROM `email` AS `E`, `department` AS `D`
                    WHERE `E`.`email` = `D`.`contactable_id` AND `D`.`department_id` = '$department_id'";    
                    
                    
        //get the result of the query for each components
        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);
        $result4 = mysqli_query($con, $sql4);
        $result5 = mysqli_query($con, $sql5);
        return (faculty::process_info_contactable($result, $result1, $result2, $result3,$result4 ,$result5 ));
        
    }



    //Extra end for end point 8
    public static function AllDepartment($con)
    {
        $sql = "SELECT `D`.`department_id`, `D`.`name`, `D`.`code`, `D`.`faculty_id`
                FROM `department` AS `D`";


        $result = mysqli_query($con, $sql);

        if (!$result)
        {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;


        
    }    

    //`T`.`title`, `P`.`phones`, `R`.`room`
    //End point 4
    public static function Instructor_Information($Instructor_id, $con)
    {

        $sql =" SELECT `I`.`instructor_id`, `I`.`name`, `I`.`department_id`
                FROM `instructor` AS `I`
                WHERE `I`.`instructor_id` = '$Instructor_id'";
        
        $sql1 =" SELECT `T`.`title`
                FROM `instructor` AS `I`, `title` AS `T`
                WHERE `I`.`instructor_id` = `T`.`instructor_id` AND `I`.`instructor_id` = '$Instructor_id'";
                
        $sql2 =" SELECT `P`.`phones`
                FROM `instructor` AS `I`, `phones` AS `P`
                WHERE `I`.`instructor_id` = `P`.`instructor_id` AND `I`.`instructor_id` = '$Instructor_id'";
                
        $sql3 =" SELECT `R`.`room`
                FROM `instructor` AS `I`, `room` AS `R`
                WHERE `I`.`instructor_id` = `R`.`instructor_id` AND `I`.`instructor_id` = '$Instructor_id'";
                
        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        $result1 = $result1->fetch_all(MYSQLI_ASSOC);
        $result2 = $result2->fetch_all(MYSQLI_ASSOC);
        $result3 = $result3->fetch_all(MYSQLI_ASSOC);

        $result["title"] = [];
        $result["phones"] = [];
        $result["room"] = [];

        foreach ($result1 as &$insert)
        {
          array_push($result["title"], $insert["title"]);
        }


        foreach ($result2 as &$insert)
        {
          array_push($result["phones"], $insert["phones"]);
        }


        foreach ($result3 as &$insert)
        {
          array_push($result["room"], $insert["room"]);
        }

        return $result;
    }




    //End point 12
    public static function Program_Information($Program_ID, $con)
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`
                FROM `program` AS `P`
                WHERE `P`.`program_id` = '$Program_ID'";

        $sql1 = "   SELECT `A`.`aka`
                    FROM `aka` AS `A`, `program` AS `Pa`
                    WHERE `A`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql2 = "   SELECT `P`.`phone`
                    FROM `phone` AS `P`, `program` AS `Pa`
                    WHERE `P`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql3 = "   SELECT `W`.`website`
                    FROM website,` AS `W`, `program` AS `Pa`
                    WHERE `W`.`contactable_id` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";

        $sql4 = "   SELECT `R`.`room(contactable)`
                    FROM room(contactable),` AS `R`,`program` AS `Pa`
                    WHERE `A`.`contactable_id` = `P`.`contactable_id` AND`Pa`.`program_id` = '$Program_ID'";

        $sql5 = "   SELECT `E`.`email`
                    FROM `email` AS `E`,`program` AS `Pa`
                    WHERE `E`.`email` = `P`.`contactable_id` AND `Pa`.`program_id` = '$Program_ID'";    

        $result = mysqli_query($con, $sql);
        //get the result of the query for each components
        $result = mysqli_query($con, $sql);
        $result1 = mysqli_query($con, $sql1);
        $result2 = mysqli_query($con, $sql2);
        $result3 = mysqli_query($con, $sql3);
        $result4 = mysqli_query($con, $sql4);
        $result5 = mysqli_query($con, $sql5);
        return (faculty::process_info_contactable($result, $result1, $result2, $result3,$result4 ,$result5 ));
    }

    //Extra end point for End point 12
    public static function AllProgram($con)
    {

        $sql = "SELECT `P`.`program_id`, `P`.`name`, `P`.`code`, `P`.`department_id`
                FROM `program` AS `P`
                WHERE `P`.`contactable_id` = `E`.`contactable_id`";

        $result = mysqli_query($con, $sql);
        if (!$result)
        {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        return $result;
    }







    //End point 11
   public static function ConcentrationForProgram($Program_ID,$con)
   {


       $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
               FROM `concentration` AS `C`
               WHERE `C`.`program_id` = '$Program_ID'";
       $result = mysqli_query($con, $sql);
       if (!$result)
       {
           return false;
       }

       $result = $result->fetch_all(MYSQLI_ASSOC);
       return $result;
   }


    //Extra end point for end point 11
    public static function AllConcentration($con)
    {


        $sql = "SELECT `C`.`program_id`, `C`.`name`, `C`.`description`
                FROM `concentration` AS `C`";
        $result = mysqli_query($con, $sql);
        if (!$result)
        {
            return false;
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;
    }


    //End point 2
    public static function Account_Signup($email, $password, $con)
    {                                                            
        $sql = "INSERT INTO `user` (`email`, `password`) VALUES ('$email','$password')";
        $result = mysqli_query($con, $sql);
        if (!$result)
        {
            return false;
        }


        $sql = "SELECT `U`.`user_id`
                FROM user as U
                WHERE `U`.`email` = '$email'";

        $result = mysqli_query($con, $sql);
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];

        $result["email"] = $email;
        $result["password"] = $password;
        return $result;
    }



    
    //End point 9
    public static function Enroll_Plan($term, $year, $con)
    {
        $currentID = $_SESSION['user_id'];
        $sql = "SELECT `course_id`
                FROM `enrolls`
                WHERE `user_id` = '$currentID' AND `term` = '$term' AND `year` = '$year'";
        $result = mysqli_query($con, $sql);
        if (!$result)
        {
            return false;
        }
 
        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        return $result;
    }




    //End point 15
    public static function View_Stat($con)
    {

        $sql = "SELECT COUNT(*)
                FROM `user`";
        $result = mysqli_query($con, $sql);
        
        if (!$result)
        {
            return false;
        }
 
        $result = $result->fetch_all(MYSQLI_ASSOC);
        return $result;           
    }



}