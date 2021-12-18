<?php

use App\StatusCodes;
use App\Account;


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
});

/*
Flight::map('authenticate', function () {
    if (!Account::Authenticate()) {
        Flight::ret(401, "Sign in is required");
        Flight::stop();
        die();
    }
});*/
