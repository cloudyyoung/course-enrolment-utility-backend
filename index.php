<?php
session_start();

require __DIR__ . '/vendor/autoload.php';

use App\StatusCodes;

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


// End point 10 - Student Information
Flight::route('GET /api/account/student', function () {
    Flight::handle("Student::StudentInformation");
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
    $major = "[]";
    $minor = "[]";
    $concentration = "[]";

    @$major = Flight::put()["major"];
    @$minor = Flight::put()["minor"];
    @$concentration = Flight::put()["concentration"];

    if($major == null) {
        $major = "[]";
    }

    if ($minor == null) {
        $minor = "[]";
    }

    if ($concentration == null) {
        $concentration = "[]";
    }
    
    Flight::handle("Student::UpdateMajorMinorConcentration", $major, $minor, $concentration);
});


// End point 14
Flight::route('PUT /api/account/student/plan/@year:[0-9]{4}/@term', function ($year, $term) {
    $course_id = "[]";
    
    @$course_id = Flight::put()["course_id"];

    if ($course_id == null) {
        $course_id = "[]";
    }

    Flight::handle("Student::UpdateEnrolmentPlan", $term, $year, $course_id);
});


// End point 15
Flight::route('GET /api/account/student/plan/@year:[0-9]{4}/@term', function ($year, $term) {
    Flight::handle("Student::GetEnrolmentPlan", $term, $year);
});


// End point 16
Flight::route('GET /api/account/admin/statistics', function () {
    Flight::handle("Admin::WebsiteStatistics");
});


// End point 17
Flight::route('PUT /api/account/password', function () {
    $password = Flight::put()["password"];
    Flight::handle("Account::ChangePassword", $password);
});


Flight::route("*", function () {
    Flight::ret(StatusCodes::NOT_FOUND, "Endpoint not found", null);
});

Flight::start();
