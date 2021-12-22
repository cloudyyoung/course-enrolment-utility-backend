<?php

namespace App;

use Flight;
use App\MySQLDatabaseQueryException;
use App\InternalErrorException;
use App\IncorrectUsernameOrPasswordException;

class Account
{
    protected static function AuthenticateSession()
    {
        if (isset($_SESSION['user_id']) == false) {
            throw new UnauthorizedAccessException();
        }
    }

    // End point 1
    public static function LogIn($username, $password)
    {
        $sql = "CALL `EP1_LogIn`('$username', '$password');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        }else if ($result->num_rows == 0) {
            throw new IncorrectUsernameOrPasswordException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        unset($result["password"]);
        
        //set the session and return the result
        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['type'] = $result['type'];
        
        return $result;
    }

    
    // End point 2
    public static function Signup($email, $password)
    {
        $sql = "CALL `EP2_SignUp`('$email', '$password');";
        $result = Flight::mysql($sql);
        if ($result === false) {
            // If mysql error is complaining about duplicated entry
            $message = Flight::get("mysql_connection")->error;
            if(str_starts_with($message, "Duplicate entry")){
               throw new EmailAlreadyRegisteredException();
            }
            
            throw new MySQLDatabaseQueryException();
        }
        
        $result = $result->fetch_all(MYSQLI_ASSOC);
        if(count($result) == 0){
            throw new InternalErrorException();
        }

        $result = $result[0];
        unset($result["password"]);

        $result["type"] = "student";
        return $result;
    }


    // End point 3
    public static function AccountInformation()
    {
        self::AuthenticateSession();

        //get the current user's id and type
        $user_id = $_SESSION['user_id'];

        //get the email of the user and account id
        $sql = "CALL `EP3_AccountInformation`('$user_id');";
        $result = Flight::mysql($sql);

        if ($result === false) {
            throw new MySQLDatabaseQueryException();
        } else if ($result->num_rows == 0) {
            throw new UnauthorizedAccessException();
        }

        $result = $result->fetch_all(MYSQLI_ASSOC);
        $result = $result[0];
        return $result;
    }
}
