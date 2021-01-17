<?php
include "../../db.php";

if(!isset($_POST['username'])) {
    echo "ERROR: Could not set username, please contact support.";
    exit();
}

// User input
if(isset($_POST['email']) && $_POST['email'] != "") {

    $username = $_POST['username'];
    $email = $_POST['email'];

    // check email valid
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "This email is invalid.";
        exit();
    }

    try {
        // Determine if other user already used this email that user input
        $sql_check = "SELECT email FROM users WHERE email = :email AND username != :username";
        $stmt = $pdo->prepare($sql_check);
        $stmt->execute([
            ':email' => $email,
            ':username' => $username
        ]);
        $row = $stmt->rowCount();
        if($row > 0) {
            echo "Email is already in use.";
            exit();
        }

        $sql_update = "UPDATE users SET email = :email WHERE username = :username";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([
            ':email' => $email,
            ':username' => $username
        ]);
        echo "Update successful.";
    } catch (Exception $ex) {
        echo("Internal error, please contact support");
        error_log("updateEmail.php, SQL error=" . $ex->getMessage());
    }
} else {
    echo "You must provide an email.";
}

?>
