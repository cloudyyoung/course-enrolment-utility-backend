<?php
session_start();



require __DIR__ . '/vendor/autoload.php';
require "app/util.php";

use App\StatusCodes;
use App\Section;
use App\Faculty;
use App\Course;
use App\Account;


// Connecting to MySQL database
$mysql_connection = mysqli_connect("155.138.157.78", "ucalgary", "cv0V9c9ZqCf55g.0", "ucalgary");
if (mysqli_connect_errno()) {
    Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Server cannot establish connection with database", null);
    die();
}
Flight::map("mysql", function ($sql) use ($mysql_connection) {
    return mysqli_query($mysql_connection, $sql);
});

// Connecting to MongoDB database
$mongo_connection = new \MongoDB\Client(
    'mongodb+srv://ucalgary:ureqIynl0ZMm0GGr@cluster0.yoz3k.mongodb.net/myFirstDatabase?retryWrites=true&w=majority'
);
$mongo_database = $mongo_connection->requisite->CPSC;
Flight::map("mongo", function ($collection, $query = []) use ($mongo_database) {
    return $mongo_database->$collection->find($query);
});


//End Point 7
Flight::route('GET /api/faculty(/@faculty_id:[0-9]{4})', function ($faculty_id) {
    //get the faculty_id by listening
    //$faculty_id = $_GET["faculty_id"];

    
        $result = null;
        if ($faculty_id == null) {
            $result = faculty::AllFaculty();
        } else {
            $result = faculty::FacultyInformation($faculty_id);
        }

        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});


//End point 8
Flight::route('GET /api/department(/@department_id:[0-9]{5})', function ($department_id) {

    //get the faculty_id by listening
    //$department_id = $_GET["department_id"];

    
        $result = null;
        if ($department_id == null) {
            $result = faculty::AllDepartment();
        } else {
            $result = faculty::DepartmentInformation($department_id);
        }

        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});


//End point 4
Flight::route('GET /api/instructor/@instructor_id:[0-9]{6}', function ($instructor_id) {

    
        $result = faculty::InstructorInformation($instructor_id);
        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});



//End point 12
Flight::route('GET /api/program(/@program_id:[0-9]{5})', function ($program_id) {

    //get the faculty_id by listening
    // $Program_id = $_GET["Program_id"];

    
        $result = null;
        if ($program_id == null) {
            $result = faculty::ProgramInformation($program_id);
        } else {
            $result = faculty::ProgramInformation($program_id);
        }

        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});



//End point 11
Flight::route('GET /api/program(/@program_id:[0-9]{5})/concentration', function ($program_id,) {

    //get the faculty_id by listening
    //$Program_id = $_GET["Program_ID"];
    //$Concentration_Name = $_GET["Concentration_Name"];

    
        $result = null;

        if ($program_id == null) {
            $result = faculty::AllConcentration();
        } else {
            $result = faculty::ConcentrationForProgram($program_id);
        }

        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});




//End point 2
Flight::route('POST /api/account', function () {

    //get the faculty_id by listening
    $email = $_POST["email"];
    $password = $_POST["password"];

    $email = mysqli_real_escape_string($email);
    $password = mysqli_real_escape_string($password);

        $result = Account::Account_Signup($email, $password);
        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, "Email already exists.", null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});




//End point 9
Flight::route('GET /api/account/student/plan/@year:[0-9]{4}/@term', function ($year, $term) {

    $year = mysqli_real_escape_string($year);
    $term = mysqli_real_escape_string($term);

    $result = Account::Enroll_Plan($term, $year);
        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});




//End point 15
Flight::route('GET /api/account/admin/statistics', function () {


    
        $result = Account::View_Stat();
        if ($result == null) {
            Flight::ret(StatusCodes::UNAUTHORIZED, "Unauthorized request", $_SESSION);
        } else if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});




//End point 5
Flight::route('GET /api/course(/@code:[A-Za-z]{3,4}(/@number:[0-9]{3}))', function ($code, $number) {

    //$course_id = $_GET["course_id"];
    
        $result = null;
        //If Code and number are null then get all courses
        if ($code == null && $number == null) {
            $result = Course::AllCourses();
        }

        //if only course is given
        else if ($number == null) {
            $result = Course::CoursesCode($code);
        }

        //If both are given
        else {
            $result = Course::CourseInformation($code, $number);
        }


        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});



//End point 5 with CID
Flight::route('GET /api/course(/@course_id:[0-9]{4})', function ($course_id) {

    //$course_id = $_GET["course_id"];
    

        $result = Course::CourseInformation_CID($course_id);

        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, "Internal error occured", null);
        } else if ($result == null) {
            Flight::ret(StatusCodes::NOT_FOUND, "Course not FOUND", null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});



//End point 6
Flight::route('GET /api/course/@code:[A-Za-z]{3,4}/@number:[0-9]{3}/section/@year:[0-9]{4}/@term', function ($code, $number, $year, $term) {
    
        $result = section::Section_Information($code, $number, $term, $year);
        if ($result === false) {
            Flight::ret(StatusCodes::NOT_FOUND, null, null);
        } else {
            Flight::ret(StatusCodes::OK, null, $result);
        }
    
});





//End point 1
Flight::route('PUT /api/account', function () {
    $email = Flight::put()["email"];
    $password = Flight::put()["password"];

    $account = account::Authenticate($email, $password);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else if (!$account) {
        Flight::ret(403, "Internal error", null);
    } else {
        Flight::ret(200, "OK", $account);
    }
});



//End point 3
Flight::route('GET /api/account', function () {

    if (isset($_SESSION['user_id']) == false) {
        Flight::ret(401, "Please log in first.");
    }

    $account = account::Account_Information();
    if ($account == null) {
        Flight::ret(500, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account);
    }
});


//End point 13
Flight::route('PUT /api/account/student', function () {
    if (isset($_SESSION['user_id']) == false) {
        Flight::ret(401, "Please log in first.");
    }

    $major = [];
    $minor = [];
    $concentration = [];

    @$major = Flight::put()["major"];
    @$minor = Flight::put()["minor"];
    @$concentration = Flight::put()["concentration"];

    $account = account::SetMajorMinor($major, $minor, $concentration);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account);
    }
});



//End point 14

Flight::route('PUT /api/account/student/plan/@year:[0-9]{4}/@term', function ($year, $term) {

    $course_id = Flight::put()["course_id"];

    if (isset($_SESSION['user_id']) == false) {
        Flight::ret(401, "Please log in first.");
    }

    $account = account::SetPlan($term, $year, $course_id);
    if ($account === false) {
        Flight::ret(StatusCodes::NOT_FOUND, "Unauthroized access", null);
    }
    Flight::ret(200, "OK", $account);
});


//End point 10
Flight::route('GET /api/account/student', function () {

    if (isset($_SESSION['user_id']) == false) {
        Flight::ret(401, "Please log in first.");
    }

    $account = account::Student_Information();
    if ($account == null) {
        Flight::ret(401, "Unexpected error.");
    } else {
        Flight::ret(200, "OK", $account);
    }
});


Flight::route("*", function () {
    Flight::ret(StatusCodes::NOT_FOUND, "Endpoint not found", null);
});

Flight::start();
