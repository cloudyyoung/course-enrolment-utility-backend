<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
require "app/util.php";

use App\StatusCodes;
use App\Section;
use App\Faculty;
use App\Course;
use App\Account;



//End Point 7
Flight::route('GET /api/faculty(/@faculty_id:[0-9]{4})', function ($faculty_id) {
    if ($faculty_id == null) {
        $result = Faculty::AllFaculty();
    } else {
        $result = Faculty::FacultyInformation($faculty_id);
    }

    if ($result === false) {
        Flight::ret(StatusCodes::NOT_FOUND, null, null);
    } else {
        Flight::ret(StatusCodes::OK, null, $result);
    }
});


//End point 8
Flight::route('GET /api/department(/@department_id:[0-9]{5})', function ($department_id) {
    if ($department_id == null) {
        $result = Faculty::AllDepartment();
    } else {
        $result = Faculty::DepartmentInformation($department_id);
    }

    if ($result === false) {
        Flight::ret(StatusCodes::NOT_FOUND, null, null);
    } else {
        Flight::ret(StatusCodes::OK, null, $result);
    }
});


//End point 4
Flight::route('GET /api/instructor/@instructor_id:[0-9]{6}', function ($instructor_id) {
    $result = Faculty::InstructorInformation($instructor_id);
    if ($result === false) {
        Flight::ret(StatusCodes::NOT_FOUND, null, null);
    } else {
        Flight::ret(StatusCodes::OK, null, $result);
    }
});


//End point 12
Flight::route('GET /api/program(/@program_id:[0-9]{5})', function ($program_id) {
    if ($program_id == null) {
        $result = Faculty::ProgramInformation($program_id);
    } else {
        $result = Faculty::ProgramInformation($program_id);
    }

    if ($result === false) {
        Flight::ret(StatusCodes::NOT_FOUND, null, null);
    } else {
        Flight::ret(StatusCodes::OK, null, $result);
    }
});


//End point 11
Flight::route('GET /api/program(/@program_id:[0-9]{5})/concentration', function ($program_id,) {
    if ($program_id == null) {
        $result = Faculty::AllConcentration();
    } else {
        $result = Faculty::ConcentrationForProgram($program_id);
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

    $email = Flight::mysql_escape($email);
    $password = Flight::mysql_escape($password);

    $result = Account::Account_Signup($email, $password);
    if ($result === false) {
        Flight::ret(StatusCodes::NOT_FOUND, "Email already exists.", null);
    } else {
        Flight::ret(StatusCodes::OK, null, $result);
    }
});


//End point 9
Flight::route('GET /api/account/student/plan/@year:[0-9]{4}/@term', function ($year, $term) {
    $year = Flight::mysql_escape($year);
    $term = Flight::mysql_escape($term);

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

    $account = Account::Authenticate($email, $password);
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

    $account = Account::Account_Information();
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

    $account = Account::SetMajorMinor($major, $minor, $concentration);
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

    $account = Account::SetPlan($term, $year, $course_id);
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

    $account = Account::Student_Information();
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
