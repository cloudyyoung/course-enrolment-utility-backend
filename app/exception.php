<?php

namespace App;

use \Exception;
use App\StatusCodes;

class UnauthorizedAccessException extends Exception
{
    public function __construct($message = "Unauthorized Access", Exception $previous = null) {
        parent::__construct($message, StatusCodes::UNAUTHORIZED, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

class IncorrectUseranemOrPasswordException extends Exception
{
    public function __construct($message = "Incorrect username or password", Exception $previous = null) {
        parent::__construct($message, StatusCodes::FORBIDDEN, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

class InternalErrorException extends Exception
{
    public function __construct($message = "Internal error", Exception $previous = null) {
        parent::__construct($message, StatusCodes::INTERNAL_SERVER_ERROR, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

class EmailAlreadyRegisteredException extends Exception
{
    public function __construct($message = "Email already registered", Exception $previous = null) {
        parent::__construct($message, StatusCodes::CONFLICT, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

class NotFoundException extends Exception
{
    public function __construct($message = "Not found", Exception $previous = null) {
        parent::__construct($message, StatusCodes::NOT_FOUND, $previous);
    }

    public function __toString() {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

