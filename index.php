<?php

session_start();

require __DIR__ . '/vendor/autoload.php';
require "app/util.php";

use App\Lobby;
use App\Account;


$larp_db = $client->larp;

Flight::route('/account/signin', function () {
    $username = Flight::request()->data->username;
    $password = Flight::request()->data->password;
    $account = Account::SignIn($username, $password);
    if ($account == null) {
        Flight::ret(401, "Username or password incorrect");
    } else {
        Flight::ret(200, "OK", $account->info());
    }
});


Flight::route('/lobby/@lobby_id:[0-9a-z]{24}(/@operation)', function ($lobby_id, $operation) {
    Flight::authenticate();
    Lobby::Lobby(["lobby_id" => $lobby_id], $operation);
});


Flight::route('/account', function () {
    Flight::authenticate();
    Flight::ret(200, "OK", Account::$account->info());
});

Flight::route('/account/signout', function () {
    Flight::authenticate();
    Account::SignOut();
    Flight::ret(200, "OK");
});

Flight::start();
