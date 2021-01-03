<?php

if(isset($_POST['loginButton'])) {

    $usernameORemail = $_POST['loginUsername'];
    $password = $_POST['loginPassword'];

    // the $field receive true or false from Account.php
    // If true, use email to login, otherwise, use username to login.
    $field = filter_var($usernameORemail, FILTER_VALIDATE_EMAIL) ? 
    $account->loginWithEmail($usernameORemail, $password) : $account->loginWithUsername($usernameORemail, $password);

    // $field is true, it will be directed to index.php
    if($field) {
        // If true, save username or email into session in order to determine that whether or not user login.
        // If user does not login, the redirect action will happen in index.php file.
        $_SESSION['userLoggedIn'] = $usernameORemail;
        header("Location: index.php");
    }
}

?>