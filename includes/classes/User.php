<?php

class User {

    private $pdo;
    private $username;

    public function __construct($pdo, $username) {
        $this->pdo = $pdo;
        $this->username = $username;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT email FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $this->username
            ]);
            $row = $stmt->fetch();
            return $row->email;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("User.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getUserPic() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT profilePic FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $this->username
            ]);
            $row = $stmt->fetch();
            return $row->profilePic;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("User.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getFirstnameAndLastname() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT CONCAT(firstname, ' ', lastname) as name FROM users WHERE username = :username";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $this->username
            ]);
            $row = $stmt->fetch();
            return $row->name;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("User.php, SQL error=" . $ex->getMessage());
        }
    }
}

?>