<?php

namespace App;

use Flight;
use Throwable;

class Users extends Base
{

    public $id = 0;
    public $username = "";
    protected $_username = ""; # request username
    protected $password = "";
    public $nickname = "";
    public $signed = false;
    public $session = "";
    public $token = "";
    public $ticket = "";

    public $lastAccess = 0;
    public $suspended = false;

    public function __construct()
    {
        $this->session = session_id();
        $this->lastAccess = time();
    }

    public function __wakeup()
    {
        if (time() - $this->lastAccess >= 10 * 60 * 1000) { # Max 10 min to re-access from database
            $this->_signin();
        }
    }

    public function read()
    {
        Flight::ret(200, "OK", $this);
    }

    public function run($funcName, $funcName2)
    {
        if ($funcName == 'signin' || $funcName == 'exist') {
            # Allow use signin function
        } else if (!$this->signed && $this->username != $this->_username) {
            Flight::ret(401, "unsigned");
            return;
        }
        $this->username = $this->_username;

        parent::run($funcName, $funcName2);
    }

    public function view($viewName, $viewName2 = null)
    {
        if (!$this->signed && $viewName != 'signin') {
            Flight::redirect('/signin');
            return;
        } else if ($this->signed && $viewName == 'signin') {
            Flight::redirect('/accounts');
            return;
        }

        if ($viewName == null) {
            $viewName = "users";
        }

        try {
            if ($viewName == 'signin') {
                Flight::set('flight.views.path', ROOT . '/view/sso');
            } else {
                Flight::set('flight.views.path', ROOT . '/view/users');
            }
            parent::view($viewName, $viewName2);
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function signin()
    {
        if (!$this->_signin()) {
            if ($this->suspended) {
                Flight::ret(406, "suspended account");
            } else {
                Flight::ret(403, "incorrect username or password");
            }
            return;
        }

        $this->signed = true;
        $this->lastAccess = time();

        $_SESSION['user'] = serialize($this);
        Flight::ret(200, "signed in", $this);
    }

    private function _signin()
    {
        $username = $this->username = Flight::request()->data['username'];
        $password = $this->password = Flight::request()->data['password'];

        $ret = Flight::sql("SELECT * FROM `users` WHERE `username`='$username' AND `password`='$password'  ");

        if (empty((array)$ret)) {
            return false;
        }

        foreach ($ret as $key => $value) {
            $this->$key = $value;
        }
        settype($this->suspended, 'boolean');

        if ($this->suspended) {
            return False;
        }

        $this->signed = true;
        return true;
    }

    public function exist()
    {
        $username = $this->username = Flight::request()->data['username'];
        $ret = Flight::sql("SELECT * FROM `users` WHERE `username`='$username'  ");


        if (!empty((array)$ret) && $username != "") {
            Flight::ret(200, "account exist", Array("nickname" => $ret->nickname));
        } else {
            Flight::ret(409, "incorrect account");
        }
    }

    public function signout()
    {
        unset($_SESSION);
        session_unset();
        session_destroy();
        $this->signed = false;

        session_start();
        session_regenerate_id();

        Flight::ret(204, "signed out");
    }

    public function password_change()
    { }
}
