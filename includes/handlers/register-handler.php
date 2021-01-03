<?php

function sanitizeFormUsername($inputText) {
    //strips a string
    $inputText = strip_tags($inputText);
    // replace spaces with empty
    $inputText = str_replace(" ", "", $inputText);
    $inputText = htmlspecialchars($inputText);
    return $inputText;
}

function sanitizeFormPassword($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = htmlspecialchars($inputText);
    return $inputText;
}

function sanitizeFormString($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    // Make the string to lowercase
    $inputText = strtolower($inputText);
    // make string's first character uppercase
    $inputText = ucfirst($inputText);
    $inputText = htmlspecialchars($inputText);
    return $inputText;
}

function sanitizeFormEmail($inputText) {
    $inputText = strip_tags($inputText);
    $inputText = str_replace(" ", "", $inputText);
    $inputText = strtolower($inputText);
    $inputText = htmlspecialchars($inputText);
    return $inputText;
}

if(isset($_POST['registerButton'])) {
    $username = sanitizeFormUsername($_POST['regUsername']);
    $firstname = sanitizeFormString($_POST['regFirstname']);
    $lastname = sanitizeFormString($_POST['regLastname']);
    $regPassword = sanitizeFormPassword($_POST['regPassword']);
    $conPassword = sanitizeFormPassword($_POST['conPassword']);
    $regEmail = sanitizeFormEmail($_POST['regEmail']);
    $conEmail = sanitizeFormEmail($_POST['conEmail']);

    // receive true or false result of register function from register-handle.php file.
    $wasSuccessed = $account->register($username, $firstname, $lastname, $regPassword, $conPassword, $regEmail, $conEmail);

    // if there are no any errors, $wasSuccessed is true, then it will go on.
    if($wasSuccessed) {
        // If true, save $username into session in order to determine that whether or not user login.
        // If user does not login, the redirect action will happen in index.php file.
        $_SESSION['userLoggedIn'] = $username;
        header("Location: index.php");
    }
}

?>