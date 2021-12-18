<?php
session_start();



require __DIR__ . '/vendor/autoload.php';
require "app/util.php";

use App\section;
use App\faculty;
use App\course;
use App\account;
use App\StatusCodes;
//if failed to connect to the database then Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) 

//If the result is wrong
// if (!$result) {Flight::ret(StatusCodes::NotFound, $mysqli->error, null) }

//Flight::ret(StatusCodes::OK, null, $result)

//ID FROM department(check,get), concentration, faculty(check,get), and program(check) implment something simlar to course where get all if no specific variables are mentioned

//End Point 7
Flight::route('GET /api/faculty(/@faculty_id:[0-9]{4})', function ($faculty_id){
    //get the faculty_id by listening
    //$faculty_id = $_GET["faculty_id"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = null;
        if ($faculty_id == null)
        {
            $result = faculty::AllFaculty($con);
        }
        else
        {
            $result = faculty::Faculty_Information($faculty_id, $con);
        }
        
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }
});


//End point 8
Flight::route('GET /api/department(/@department_id:[0-9]{5})', function ($department_id){
    
    //get the faculty_id by listening
    //$department_id = $_GET["department_id"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = null;
        if ($department_id == null)
        {   
            $result = faculty::AllDepartment($con);
        }
        else
        {
            $result = faculty::Department_Information($department_id, $con);
        }
        
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});


//End point 4
Flight::route('GET /api/instructor/@instructor_id:[0-9]{6}', function ($instructor_id){
    
    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = faculty::Instructor_Information($instructor_id, $con);
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }
});



//End point 12
Flight::route('GET /api/program(/@program_id:[0-9]{5})', function ($program_id){
    
    //get the faculty_id by listening
   // $Program_id = $_GET["Program_id"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = null;
        if ($program_id == null)
        {
            $result = faculty::Program_Information($program_id, $con);
        }

        else
        {
            $result = faculty::Program_Information($program_id, $con);
        }
        
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});



//End point 11
Flight::route('GET /api/program(/@program_id:[0-9]{5})/concentration', function ($program_id,){
    
    //get the faculty_id by listening
    //$Program_id = $_GET["Program_ID"];
    //$Concentration_Name = $_GET["Concentration_Name"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = null;

       if ($program_id == null )
        {
            $result = faculty::AllConcentration($con);
        }
        else
        {
            $result = faculty::ConcentrationForProgram($program_id,$con);
        }
        
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});




//End point 2
Flight::route('POST /api/account', function (){
    
    //get the faculty_id by listening
    $email = $_POST["email"];
    $password = $_POST["password"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = faculty::Account_Signup($email, $password, $con);
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, "Email already exists.", null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});




//End point 9
Flight::route('GET /api/account/student/plan', function (){
    
    //get the faculty_id by listening
    $term = $_GET["term"];
    $year = $_GET["year"];

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = faculty::Enroll_Plan($term, $year, $con);
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});




//End point 15
Flight::route('GET /api/account/admin/statistics', function (){
    

    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = faculty::View_Stat($con);
        if($result == null){
            Flight::ret(StatusCodes::UNAUTHORIZED, "Unauthorized request", null) ;
        }else if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});




//End point 5
Flight::route('GET /api/course(/@code:[A-Za-z]{3,4}(/@number:[0-9]{3}))', function($code, $number){
    
    //$course_id = $_GET["course_id"];
    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = null;
        //If Code and number are null then get all courses
        if ($code == null && $number == null)
        {
            $result = course::AllCourses( $con);
        }

        //if only course is given
        else if ($number == null)
        {
            $result = course::CoursesCode($code, $con);
        }
        
        //If both are given
        else
        {
            $result = course::Course_Information($code, $number, $con);
        }
        
       
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});



//End point 6
Flight::route('GET /api/course/@code:[A-Za-z]{3,4}/@number:[0-9]{3}/section/@year:[0-9]{4}/@term', function ($code, $number, $year, $term){
    //connect to the SQL database
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }
    else
    {
        $result = section::Section_Information($code, $number, $term, $year, $con);
        if (!$result) 
        {
            Flight::ret(StatusCodes::NOT_FOUND, null, null) ;
        } 
        else
        {
            Flight::ret(StatusCodes::OK, null, $result) ;
        }        
    }

});





//End point 1
Flight::route('PUT /api/account', function () {
    $email = Flight::put()["email"];
    $password = Flight::put()["password"];
    
    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }

    $account = account::Authenticate($email, $password, $con);
    if(!$account){
        Flight::ret(403, null, null);
    }else if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account);
    }
});



//End point 3
Flight::route('GET /api/account', function () {

    if (isset($_SESSION['user_id']) == false)
    {
        Flight::ret(401, "Please log in first.");
    }

    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }

    $account = account::Account_Information( $con);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account);
    }
});


//End point 13
Flight::route('PUT /api/account/student', function () {
    if (isset($_SESSION['user_id']) == false)
    {
        Flight::ret(401, "Please log in first.");
    }

    $major = [];
    $minor = [];
    @$major = Flight::put()["major"];
    @$minor = Flight::put()["minor"];

    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }

    $account = account::SetMajorMinor( $con, $major, $minor);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account);
    }
});



//End point 14

Flight::route('PUT /api/account/student/plan', function () {

    $course_id = Flight::put()["course_id"];
    $term = Flight::put()["term"];
    $year = Flight::put()["year"];

    if (isset($_SESSION['user_id']) == false)
    {
        Flight::ret(401, "Please log in first.");
    }

    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }

    $account = account::SetPlan($term, $year, $course_id, $con);
    if ($account == null) {
        Flight::ret(401, "Unexpected error.");
    } else {
        Flight::ret(200, "OK", $account);
    }
});



Flight::route('GET /api/account/student', function () {

    if (isset($_SESSION['user_id']) == false)
    {
        Flight::ret(401, "Please log in first.");
    }

    $con = mysqli_connect("155.138.157.78","ucalgary","cv0V9c9ZqCf55g.0","ucalgary");
    if (mysqli_connect_errno())
    {
        Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Unable to connect to the database", null) ;
    }

    $account = account::Student_Information($con);
    if ($account == null) {
        Flight::ret(401, "Unexpected error.");
    } else {
        Flight::ret(200, "OK", $account);
    }
});



// Flight::ret(StatusCodes::BAD_REQUEST, "Operation is not supported", null);

Flight::start();



/*


use App\Lobby;
use App\Account;


$larp_db = $client->larp;

Flight::route('/account/signin', function () {
    $email = Flight::request()->data->email;
    $password = Flight::request()->data->password;
    $account = Account::SignIn($email, $password);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account->info());
    }
});


Flight::route('/lobby/@lobby_id:[0-9a-z]{24}(/@operation)', function ($lobby_id, $operation) {
    Flight::authenticate();
    Lobby::Lobby(["lobby_id" => $lobby_id], $operation);
});


Flight::route('/account', function () {
    Flight::authenticate();
    Flight::ret(200, "OK", Account::$account->info());
});

Flight::route('/account/signout', function () {
    Flight::authenticate();
    Account::SignOut();
    Flight::ret(200, "OK");
});

Flight::start();*/

