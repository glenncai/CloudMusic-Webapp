<?php
include "../../db.php";

if(!isset($_POST['username'])) {
    echo "ERROR: Could not set username, please contact support.";
    exit();
}

if(!isset($_POST['oldPassword']) || !isset($_POST['newPassword1']) || !isset($_POST['newPassword2'])) {
    echo "Not all passwords have been set;";
    exit();
}

if(isset($_POST['oldPassword']) == "" || isset($_POST['newPassword1']) == "" || isset($_POST['newPassword2']) == "") {
    echo "Please fill in all fields.";
    exit();
}

$username = $_POST['username'];
$oldPassword = $_POST['oldPassword'];
$newPassword1 = $_POST['newPassword1'];
$newPassword2 = $_POST['newPassword2'];

$hashFormat = "$2y$10$";
$salt = "youcannotstealmypwhaha"; 
$hashF_and_salt = $hashFormat . $salt;
$oldPassword = crypt($oldPassword, $hashF_and_salt);

$sql_check = "SELECT * FROM users WHERE username = :username AND password = :password";
$stmt_check = $pdo->prepare($sql_check);
$stmt_check->execute([
    ':username' => $username,
    ':password' => $oldPassword
]);
$row_check = $stmt_check->rowCount();
if($row_check != 1) {
    echo "Your password is incorrect.";
    exit();
}

if($newPassword1 != $newPassword2) {
    echo "Your new password do not match.";
    exit();
}

if(!preg_match('/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!.@#$%]{8,25}$/', $newPassword1)) {
    echo "Your password must be between 8 and 25 characters, must contain at least 1 number and 1 letter, and may contain any of these characters: !.@#$%";
    exit();
}

$newPasswordSet = crypt($newPassword1, $hashF_and_salt);
$sql_password = "UPDATE users SET password = :password WHERE username = :username";
$stmt_password = $pdo->prepare($sql_password);
$stmt_password->execute([
    ':password' => $newPasswordSet,
    ':username' => $username
]);
echo "update successful.";
?>
