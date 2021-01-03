<?php

class Account {

    private $errorArray;
    private $pdo;

    public function __construct($pdo) {
        $this->errorArray = array();
        $this->pdo = $pdo;
    }

    public function loginWithUsername($username, $password) {
        $hashFormat = "$2y$10$";
        $salt = "youcannotstealmypwhaha"; 
        $hashF_and_salt = $hashFormat . $salt;
        $password = crypt($password, $hashF_and_salt);

        try {
            $sqlLogin = "SELECT * FROM users WHERE username = :username AND password = :password";
            $pdo = $this->pdo;
            $stmtLogin = $pdo->prepare($sqlLogin);
            $stmtLogin->execute([
                ':username' => $username,
                ':password' => $password
            ]);
    
            $usernameCount = $stmtLogin->rowCount();
            if($usernameCount == 1) {
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginFailedUsername);
                return false;
            }
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Account.php, SQL error=" . $ex->getMessage());
        }
    }

    public function loginWithEmail($email, $password) {
        $hashFormat = "$2y$10$";
        $salt = "youcannotstealmypwhaha"; 
        $hashF_and_salt = $hashFormat . $salt;
        $password = crypt($password, $hashF_and_salt);

        try {
            $sqlLogin = "SELECT * FROM users WHERE email = :email AND password = :password";
            $pdo = $this->pdo;
            $stmtLogin = $pdo->prepare($sqlLogin);
            $stmtLogin->execute([
                ':email' => $email,
                ':password' => $password
            ]);
    
            $emailCount = $stmtLogin->rowCount();
            if($emailCount == 1) {
                return true;
            } else {
                array_push($this->errorArray, Constants::$loginFailedEmail);
                return false;
            }
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Account.php, SQL error=" . $ex->getMessage());
        }
    }

    public function register($username, $firstname, $lastname, $regPassword, $conPassword, $regEmail, $conEmail) {
        $this->validateUsername($username);
        $this->validateFirstname($firstname);
        $this->validateLastname($lastname);
        $this->validatePasswords($regPassword, $conPassword);
        $this->validateEmails($regEmail, $conEmail);

        // Check if there are any errors. Then insert user's data into database if no any errors.
        if(empty($this->errorArray)) {
            // this is return true
            return $this->insertUsersData($username, $firstname, $lastname, $regPassword, $regEmail);
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

    private function insertUsersData($username, $firstname, $lastname, $regPassword, $regEmail) {
        $hashFormat = "$2y$10$";
        $salt = "youcannotstealmypwhaha"; 
        $hashF_and_salt = $hashFormat . $salt;
        $regPassword = crypt($regPassword, $hashF_and_salt);

        $profilePic = "assets/images/profile-pics/icon.png";

        // Insert users's data into database
        try {
            $sql = "INSERT INTO users (username, firstname, lastname, email, password, signUpDate, profilePic) 
            VALUES (:username, :firstname, :lastname, :email, :password, NOW(), :profilePic)";
            $pdo = $this->pdo;
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $regEmail,
                ':password' => $regPassword,
                ':profilePic' => $profilePic
            ]);
    
            $result = $stmt;
            return $result;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Account.php, SQL error=" . $ex->getMessage());
        }
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

        // Determine whether the username exists in the database
        try {
            $sql_username = 'SELECT username FROM users WHERE username = :username';
            $pdo = $this->pdo;
            $stmt_username = $pdo->prepare($sql_username);
            $stmt_username->execute([
                ':username' => $username
            ]);
    
            $usernameCount = $stmt_username->rowCount();
            if($usernameCount != 0) {
                array_push($this->errorArray, Constants::$usernameTaken);
                return;
            }
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Account.php, SQL error=" . $ex->getMessage());
        }
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

        // Determine whether the email exists in the database
        try {
            $sql_email = 'SELECT email FROM users WHERE email = :email';
            $pdo = $this->pdo;
            $stmt_email = $pdo->prepare($sql_email);
            $stmt_email->execute([
                ':email' => $regEmail
            ]);
    
            $emailCount = $stmt_email->rowCount();
            if($emailCount != 0) {
                array_push($this->errorArray, Constants::$emailTaken);
                return;
            }
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Account.php, SQL error=" . $ex->getMessage());
        }
    }

}

?>