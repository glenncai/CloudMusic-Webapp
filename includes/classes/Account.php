<?php

class Account {

    private $errorArray;

    public function __construct() {
        $this->errorArray = array();
    }

    public function register($username, $firstname, $lastname, $regPassword, $conPassword, $regEmail, $conEmail) {
        $this->validateUsername($username);
        $this->validateFirstname($firstname);
        $this->validateLastname($lastname);
        $this->validatePasswords($regPassword, $conPassword);
        $this->validateEmails($regEmail, $conEmail);

        // Check if there are any errors. Then insert user's data into database if no any errors.
        if(empty($this->errorArray)) {
            //insert db
            return true;
        } else {
            return false;
        }
    }

    public function getError($error) {
        // judge if error message is existing in errorArray
        if(!in_array($error, $this->errorArray)) {
            // no error message in errorArray
            $error = "";
        }
        return "<span class='errorMessage'>{$error}</span>";
    }

    private function validateUsername($username) {
        if(!preg_match('/^[a-zA-Z0-9]+$/u', $username)) {
            array_push($this->errorArray, Constants::$usernameNotValid);
            return;
        }

        if(strlen($username) > 25 || strlen($username) < 5) {
            array_push($this->errorArray, Constants::$usernameLength);
            return;
        }

        // check if exits
    }
    
    private function validateFirstname($firstname) {
        if(strlen($firstname) > 25 || strlen($firstname) < 2) {
            array_push($this->errorArray, Constants::$firstnameLength);
            return;
        }
    }
    
    private function validateLastname($lastname) {
        if(strlen($lastname) > 25 || strlen($lastname) < 2) {
            array_push($this->errorArray, Constants::$lastnameLength);
            return;
        }
    }
    
    private function validatePasswords($regPassword, $conPassword) {
        if($regPassword != $conPassword) {
            array_push($this->errorArray, Constants::$passwordNotMatch);
        }

        if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!.@#$%]{8,25}$/', $regPassword)) {
            array_push($this->errorArray, Constants::$passwordNotValid);
            return;
        }
    }
    
    private function validateEmails($regEmail, $conEmail) {
        if($regEmail != $conEmail) {
            array_push($this->errorArray, Constants::$emailNotMatch);
            return;
        }

        if(!filter_var($regEmail, FILTER_VALIDATE_EMAIL)) {
            array_push($this->errorArray, Constants::$emailNotValid);
            return;
        }

        // check if exits
    }

}

?>