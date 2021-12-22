<?php
session_start();

require __DIR__ . '/vendor/autoload.php';
require "app/util.php";
require "app/exception.php";

use App\StatusCodes;
use App\Section;
use App\Instructor;
use App\Faculty;
use App\Department;
use App\Course;
use App\Account;

// End point 1 - Account Log In
Flight::route('PUT /api/account', function () {
    $email = "";
    $password = "";
    
    @$email = Flight::put()["email"];
    @$password = Flight::put()["password"];

    Flight::handle("Account::LogIn", $email, $password);
});


// End point 2 - Account Sign Up
Flight::route('POST /api/account', function () {
    //get the faculty_id by listening
    $email = "";
    $password = "";
    
    @$email = $_POST["email"];
    @$password = $_POST["password"];

    Flight::handle("Account::SignUp", $email, $password);
});


// End point 3 - Account Information
Flight::route('GET /api/account', function () {
    Flight::handle("Account::AccountInformation");
});


// End point 4 - Instructor Information
Flight::route('GET /api/instructor/@instructor_id:[0-9]{6}', function ($instructor_id) {
    Flight::handle("Instructor::InstructorInformation", $instructor_id);
});


// End point 5.1 ~ 5.3 - Course Information
Flight::route('GET /api/course(/@code:[A-Za-z]{3,4}(/@number:[0-9]{3}))', function ($code, $number) {
    //If Code and number are null then get all courses
    if ($code == null && $number == null) {
        Flight::handle("Course::AllCourses");
    }

    //if only course is given
    else if ($number == null) {
        Flight::handle("Course::CoursesCode", $code);
    }

    //If both are given
    else {
        Flight::handle("Course::CourseCodeNumber", $code, $number);
    }
});


// End point 5.4 - Course Information by Course_ID
Flight::route('GET /api/course(/@course_id:[0-9]{4})', function ($course_id) {
    Flight::handle("Course::CourseInformation_CID", $course_id);
});


// End point 6 - Course Section Information
Flight::route('GET /api/course/@code:[A-Za-z]{3,4}/@number:[0-9]{3}/section/@year:[0-9]{4}/@term', function ($code, $number, $year, $term) {
    Flight::handle("Section::SectionInformation", $code, $number, $term, $year);
});


// End Point 7 - Faculty Information
Flight::route('GET /api/faculty(/@faculty_id:[0-9]{4})', function ($faculty_id) {
    if ($faculty_id == null) {
        Flight::handle("Faculty::AllFaculty");
    } else {
        Flight::handle("Faculty::FacultyInformation", $faculty_id);
    }
});


// End point 8 - Department Information
Flight::route('GET /api/department(/@department_id:[0-9]{5})', function ($department_id) {
    if ($department_id == null) {
        Flight::handle("Department::AllDepartment");
    } else {
        Flight::handle("Department::DepartmentInformation", $department_id);
    }
});


// End point 9 - Student Enrollment Plan
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


// End point 10 - Student Information
Flight::route('GET /api/account/student', function () {

    if (isset($_SESSION['user_id']) == false) {
        Flight::ret(401, "Please log in first.");
    }

    $account = Account::StudentInformation();
    if ($account == null) {
        Flight::ret(401, "Unexpected error.");
    } else {
        Flight::ret(200, "OK", $account);
    }
});


// End point 11 - Concentration Information
Flight::route('GET /api/program(/@program_id:[0-9]{5})/concentration', function ($program_id,) {
    if ($program_id == null) {
        Flight::handle("Concentration::AllConcentration");
    } else {
        Flight::handle("Concentration::ConcentrationForProgram", $program_id);
    }
});


// End point 12 - Program Information
Flight::route('GET /api/program(/@program_id:[0-9]{5})', function ($program_id) {
    if ($program_id == null) {
        Flight::handle("Program::AllProgram");
    } else {
        Flight::handle("Program::ProgramInformation", $program_id);
    }
});


// End point 13 - Student: Set major, minor and concentration
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


// End point 14
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


// End point 15
Flight::route('GET /api/account/admin/statistics', function () {
    Flight::handle("Admin::WebsiteStatistics");
});



Flight::route("*", function () {
    Flight::ret(StatusCodes::NOT_FOUND, "Endpoint not found", null);
});

Flight::start();
