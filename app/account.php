<?php

namespace App;

use MongoDB\Bson\ObjectId;
use Flight;

use App\Base;

class Account extends Base
{
    private static $account_db;
    public static $account;
    private $exist;
    public $account_id;
    public $username;
    private $password;
    public $nickname;

    public function __construct($object)
    {
        if (self::$account_db == null) {
            self::$account_db = Flight::get("larp_db")->account;
        }

        if (is_array($object)) $object = (object) $object;

        $account = null;
        if (isset($object->account_id)) {
            $account = self::$account_db->findOne(["_id" => new ObjectId($object->account_id)]);
        } else if (isset($object->username)) {
            $account = self::$account_db->findOne(["username" => $object->username]);
        }

        if ($account != null) {
            $this->exist = true;
            $this->account_id = (string)($account->_id);
            $this->username = $account->username;
            $this->password = $account->password;
            $this->nickname = $account->nickname;
        } else {
            $this->exist = false;
        }
    }

    public function dump()
    {
        return get_object_vars($this);
    }

    public static function SignIn($username, $password)
    {
        $account = new Account(["username" => $username]);

        if (!$account->exist || $account->password != $password) {
            return null;
        }

        self::$account = $account;
        $_SESSION["account_id"] = $account->account_id;

        return $account;
    }

    public static function Authenticate()
    {
        if (!isset($_SESSION["account_id"])) {
            return false;
        }

        $account_id = $_SESSION["account_id"];
        $account = new Account(["account_id" => new ObjectId($account_id)]);

        if (!$account->exist) {
            return false;
        }

        self::$account = $account;
        return true;
    }

    public static function SignOut()
    {
        $_SESSION["account_id"] = null;
    }
}
