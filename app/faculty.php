<?php

namespace App;

class Faculty 
{
    public function __construct($object)
    {
        
    }

    //End point 7
    public static function Faculty_Information($faculty_id)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "SELECT F.Fauclty_ID, F.Name, F.Code, F.contactable_ID, A.Aka, P.Phone, W.Website, R.Room, E.Email
                FROM FACULTY as F, CONTACTABLE as C, AKA as A, PHONE AS P, WEBSITE as W, ROOM as R, EMAIL AS E
                WHERE F.Contactable_ID = A.Contactable_ID AND
                F.Contactable_ID = P.Contactable_ID AND
                F.Contactable_ID = W.Contactable_ID AND
                F.Contactable_ID = R.Contactable_ID AND
                F.Contactable_ID = E.Contactable_ID AND
                F.Faculty_ID = $faculty_id";
        $result = mysqli_query($con, $sql);
        return $result;
    }


    //End point 8
    public static function Department_Information($department_id)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "SELECT D.Department_ID, D.Name, D.Code, D.Faculty_ID, A.Aka, P.Phone, W.Website, R.Room, E.Email
                FROM DEPARTMENT as D, CONTACTABLE as C, AKA as A, PHONE AS P, WEBSITE as W, ROOM as R, EMAIL AS E
                WHERE D.Contactable_ID = A.Contactable_ID AND
                D.Contactable_ID = P.Contactable_ID AND
                D.Contactable_ID = W.Contactable_ID AND
                D.Contactable_ID = R.Contactable_ID AND
                D.Contactable_ID = E.Contactable_ID AND
                D.Department_ID = $department_id";
        $result = mysqli_query($con, $sql);
        return $result;
        
    }




    //End point 4
    public static function Instructor_Information($Instructor_id)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql =" SELECT I.Instructor_ID, I.Name, I.Department_ID, T.Title, P.Phones, R.Room
                FROM INSTRUCTOR as I, TITLE as T, PHONES as P, ROOM as R
                WHERE I.Instructor_ID = T.Instructor_ID AND
                I.Instructor_ID = P.Instructor_ID AND
                I.Instructor_ID = R.Instructor_ID AND
                I.Instructor_ID = $Instructor_id";
        $result = mysqli_query($con, $sql);
        return $result;
    }




    //End point 12
    public static function Program_Information($Program_ID)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "SELECT P.Program_ID, P.Name, P.Code, P.Department_ID, A.Aka, P.Phone, W.Website, R.Room, E.Email
                FROM PROGRAM AS P, AKA as A, PHONE AS P, WEBSITE as W, ROOM as R, EMAIL AS E
                WHERE P.Contactable_ID = A.Contactable_ID AND
                P.Contactable_ID = P.Contactable_ID AND
                P.Contactable_ID = W.Contactable_ID AND
                P.Contactable_ID = R.Contactable_ID AND
                P.Contactable_ID = E.Contactable_ID AND
                P.Program_ID = $Program_ID";

        $result = mysqli_query($con, $sql);
        return $result;
    }





    //End point 11
    public static function Concentration_Information($Program_ID, $Concentration_Name)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sql = "SELECT C.Program_ID, C.Name, C.Description
                FROM CONCENTRATION AS C
                WHERE C.Program_ID = $Program_ID AND C.Name = $Concentration_Name";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //End point 2
    public static function Account_Signup($email, $password)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
              
        $sql = "INSERT INTO users (Email, Password) VALUES ('". $email."','". $password ."')";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //End point 9
    public static function Enroll_Plan($term, $year)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "SELECT C.Code, C.Number
                FROM COURSE as C, SECTION AS C
                WHERE C.Code = S.Code AND C.Number = S.Number AND
                C.Year = $year AND C.term = $term";
        $result = mysqli_query($con, $sql);
        return $result;
    }

    //End point 10

}