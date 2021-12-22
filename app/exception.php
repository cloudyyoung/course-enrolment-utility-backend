<?php

namespace App;

use \Flight;
use App\StatusCodes;


class Exception extends \Exception{
    private $details = null;
    public function __construct(string $message, int $code, array $details = null) {
        parent::__construct($message, $code);
        $this->details = $details;
    }
    
    public function getDetails(){
        return $this->details;
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
class UnauthorizedAccessException extends Exception
{
    public function __construct(string $message = "Unauthorized Access") {
        parent::__construct($message, StatusCodes::UNAUTHORIZED);
    }
}

class IncorrectUsernameOrPasswordException extends Exception
{
    public function __construct(string $message = "Incorrect username or password") {
        parent::__construct($message, StatusCodes::FORBIDDEN);
    }
}

class InternalErrorException extends Exception
{
    public function __construct(string $message = "Internal error", $details = null) {
        parent::__construct($message, StatusCodes::INTERNAL_SERVER_ERROR, $details);
    }
}

class EmailAlreadyRegisteredException extends Exception
{
    public function __construct(string $message = "Email already registered") {
        parent::__construct($message, StatusCodes::CONFLICT);
    }
}

class NotFoundException extends Exception
{
    public function __construct(string $message = "Not found") {
        parent::__construct($message, StatusCodes::NOT_FOUND);
    }
}

class MySQLDatabaseQueryException extends Exception
{
    public function __construct() {
        $details = Array(
            "database" => "MySQL",
            "message" => Flight::get("mysql_connection")->error,
        );
        parent::__construct("Internal error", StatusCodes::BAD_REQUEST, $details);
    }
}

class InvalidIDException extends Exception
{
    public function __construct(string $message = "ID is invalid") {
        parent::__construct($message, StatusCodes::BAD_REQUEST);
    }
}