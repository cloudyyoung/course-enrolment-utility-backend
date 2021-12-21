<?php

use App\StatusCodes;
use App\InternalErrorException;
use App\Exception;


// RESTful
Flight::map('ret', function ($code = StatusCodes::NO_CONTENT, $message = '', $array = null) {
    header(StatusCodes::httpHeaderFor($code));
    http_response_code($code);

    if ($code >= StatusCodes::errorCodesBeginAt) {
        // $message = ucwords($message);
        Flight::json(array(
            "error" => array(
                "code" => $code,
                "message" => $message,
                "details" => $array,
            )
        ));
    } else if (!empty($array)) {
        Flight::json($array);
    }

    Flight::stop();
    die();
});



Flight::map("put", function () {
    parse_str(file_get_contents("php://input"), $put);
    return $put;
});


// Connecting to MySQL database
$mysql_connection = mysqli_connect("155.138.157.78", "ucalgary", "cv0V9c9ZqCf55g.0", "ucalgary");
if (mysqli_connect_errno()) {
    Flight::ret(StatusCodes::INTERNAL_SERVER_ERROR, "Server cannot establish connection with database", null);
    die();
}
Flight::map("mysql", function ($sql) use ($mysql_connection) {
    return mysqli_query($mysql_connection, $sql);
});
Flight::set("mysql_connection", $mysql_connection);

// Connecting to MongoDB database
$mongo_connection = new \MongoDB\Client(
    'mongodb+srv://ucalgary:ureqIynl0ZMm0GGr@cluster0.yoz3k.mongodb.net/myFirstDatabase?retryWrites=true&w=majority'
);
$mongo_database = $mongo_connection->requisite->CPSC;
Flight::map("mongo", function ($collection, $query = []) use ($mongo_database) {
    return $mongo_database->$collection->find($query);
});

Flight::map("mysql_escape", function ($string) use ($mysql_connection) {
    if($string == null) return null;
    return mysqli_real_escape_string($mysql_connection, $string);
});

Flight::map("handle", function (string $handler, ...$args) {
    $result = null;

    // for each argument
    foreach ($args as &$arg){
        $arg = Flight::mysql_escape($arg);
    }

    try{
        $handler = "App\\" . $handler;
        if (!is_callable($handler)) {
            $details = array(
                "message" => "Defined handler is not callable",
                "handler" => $handler,
                "args" => $args
            );
            throw new InternalErrorException("Internal error", $details);
        }
        
        $result = $handler(...$args);
    } catch (Exception $e) {
        Flight::ret($e->getCode(), $e->getMessage(), $e->getDetails());
        die();
    }

    Flight::ret(StatusCodes::OK, null, $result);
});