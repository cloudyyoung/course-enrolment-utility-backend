<?php

namespace App;

class course 
{

    public function __construct($object)
    {
        
    }

    //INCOMPLETE, WILL DO LATER
    public static function Course_Information ($code, $number)
    {
        $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
        if (mysqli_connect_errno($con))
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        $sql = "SELECT C.Course_ID, C.NoGPA, C.Repeat, C.Code, C.Number, C.Units, C.Topic, C.Notes, C.Description, C.Credit, H.Hours, A.Aka, T.Time_length
                FROM COURSE as S, HOURS as H, AKA as A, TIME_LENGTH as T
                WHERE C.Course_ID = H.Course_ID AND
                C.Course_ID = A.Course_ID AND
                C.Course_ID = T.Course_ID AND
                C.Code = $code AND C.Number = $number";

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