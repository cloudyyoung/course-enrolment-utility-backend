<?php

use App\StatusCodes;


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
    var_dump($put);
    return $put;
});
