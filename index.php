<?php

define('CONFIG', parse_ini_file('config.ini', true, INI_SCANNER_TYPED));
define('ROOT', __DIR__);

session_start();

require 'vendor/autoload.php';

Flight::set('flight.log_errors', true);
Flight::set('flight.views.path', __DIR__ . '/view');


if (CONFIG['app']['debug']) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}


Flight::map('error', function (Exception $e) {
    // Handle error
    Flight::ret(500, "Internal Server Error");
    if (CONFIG['app']['debug']) {
        echo $e;
        echo $e->getTraceAsString();
    }
});

Flight::map('notFound', function () {
    // Handle not found
    Flight::get('user')->view('404');
});



Flight::register('db', 'mysqli', array(CONFIG['database']['host'], CONFIG['database']['username'], CONFIG['database']['password'], CONFIG['database']['database']), function ($db) {
    $db->set_charset("utf8");
});

Flight::map('sql', function ($sql, $fetch_all = false) {
    $db = Flight::db();
    $res = $db->query($sql);
    if (is_bool($res)) {
        return $res;
    }

    if ($fetch_all) {
        $ret = [];
        while ($row = $res->fetch_assoc()) {
            $ret[] = (object) $row;
        }
        return $ret;
    }
    return (object) $res->fetch_assoc();
});

// RESTful
Flight::map('ret', function ($code = 204, $message = '', $array = null) {
    $message = ucwords($message);
    header("HTTP/1.1 $code $message");

    if (!empty($array)) {
        Flight::json($array);
    }
});


use App\Users;
use App\Terms;

if (isset($_SESSION['user'])) {
    Flight::set('user', unserialize($_SESSION['user']));
} else {
    Flight::set('user', new Users());
}

Flight::register('terms', 'App\Terms');


Flight::route('/', function () {
    Flight::redirect('/accounts');
});

Flight::route('GET /terms/@term', function ($term) {
    Flight::terms()->view($term);
});

Flight::route('GET /signin', function () {
    Flight::get('user')->view('signin', null);
});

Flight::route('GET /accounts(/@action(/@action2))', function ($action, $action2) {
    Flight::get('user')->view($action, $action2);
});

Flight::route('POST /accounts(/@action(/@action2))', function ($action, $action2) {
    Flight::get('user')->run($action, $action2);
});

Flight::route('*', function () {
    if (file_exists('/public/' . $_SERVER['REQUEST_URI'])) {
        return;
    }
    Flight::get('user')->view('404');
});

Flight::start();
