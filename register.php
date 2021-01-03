<?php
include "includes/db.php";
include "includes/classes/Constants.php";
include "includes/classes/Account.php";

// accept $pdo from db.php
$account = new Account($pdo);

include "includes/handlers/register-handler.php";
include "includes/handlers/login-handler.php";

// If there are some errors when we submit our form, we can
// keep the value last time what we type.
function keepValueLastTime($value) {
    if(isset($_POST[$value])) {
        echo $_POST[$value];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/css/register.css">
    <title>Cloud Music</title>
</head>
<body>

    <div class="head">
        <img src="assets/images/logo/logo.png" alt="logo">
    </div>

    <div id="heading">Discover more in cloud music...</div>

    <div class="buttonList">
        <div class="buttonListE"><button id="ad_A">Cloud Music Free</button></div>
        <div class="buttonListE"><button id="ad_B">The Best Music Webapp</button></div>
        <div class="buttonListE"><button id="ad_C">Enjoy this moment</button></div>
    </div>
    <div class="inputContainer">
        <form action="register.php" id="loginForm" method="POST">
            <div class="line"></div>
            <h2>To continue, log in to Cloud Music</h2>
            <p>
                <label for="loginUsername">Email address or username</label>
                <input type="text" id="loginUsername" name="loginUsername" placeholder="Email address or username." value="<?php keepValueLastTime('loginUsername'); ?>" required>
                <?php echo $account->getError(Constants::$loginFailedUsername); ?>
                <?php echo $account->getError(Constants::$loginFailedEmail); ?>
            </p>
            <p>
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Password." required>
            </p>
            <button class="greenButton" type="submit" name="loginButton">LOG IN</button>
            <div></div>
            <div class="hasAccountText">
                <div class="line"></div>
                <span>Don't have an account?</span>
                <button class="greyButton"  id="hideLogin" type="button">SIGN UP HERE</button>
            </div>
        </form>

        <form action="register.php" id="registerForm" method="POST">
            <div class="line"></div>
            <h2>Sign up for free to start listening.</h2>
            <p>
                <label for="regUsername">Username</label>
                <input type="text" id="regUsername" name="regUsername" placeholder="Enter your username." value="<?php keepValueLastTime('regUsername'); ?>" required>
                <?php echo $account->getError(Constants::$usernameLength); ?>
                <?php echo $account->getError(Constants::$usernameNotValid); ?>
                <?php echo $account->getError(Constants::$usernameTaken); ?>
            </p>
            <p>
                <label for="regFirstname">First name</label>
                <input type="text" id="regFirstname" name="regFirstname" placeholder="Enter your first name." value="<?php keepValueLastTime('regFirstname'); ?>" required>
                <?php echo $account->getError(Constants::$firstnameLength); ?>
            </p>
            <p>
                <label for="regLastname">Last name</label>
                <input type="text" id="regLastname" name="regLastname" placeholder="Enter your last name." value="<?php keepValueLastTime('regLastname'); ?>" required>
                <?php echo $account->getError(Constants::$lastnameLength); ?>
            </p>
            <p>
                <label for="regEmail">Email</label>
                <input type="email" id="regEmail" name="regEmail" placeholder="Enter your email." value="<?php keepValueLastTime('regEmail'); ?>" required>
                <?php echo $account->getError(Constants::$emailNotMatch); ?>
                <?php echo $account->getError(Constants::$emailNotValid); ?>
                <?php echo $account->getError(Constants::$emailTaken); ?>
            </p>
            <p>
                <label for="conEmail">Confirm your email</label>
                <input type="email" id="conEmail" name="conEmail" placeholder="Enter your email again." value="<?php keepValueLastTime('conEmail'); ?>" required>
            </p>
            <p>
                <label for="regPassword">Create a password</label>
                <input type="password" id="regPassword" name="regPassword" placeholder="Create a password." required>
                <?php echo $account->getError(Constants::$passwordNotMatch); ?>
                <?php echo $account->getError(Constants::$passwordNotValid); ?>
            </p>
            <p>
                <label for="conPassword">Confirm you password</label>
                <input type="password" id="conPassword" name="conPassword" placeholder="Confirm your password." required>
            </p>
            <button class="greenButton" type="submit" name="registerButton">SIGN UP</button>
            <div class="hasAccountText">
                <div class="line"></div>
                <span>Already have an account?</span>
                <button class="greyButton" id="hideSignup" type="button">LOGIN IN HERE</button>
            </div>
        </form>
    </div>  
    <noscript>Your browser does not support JavaScript!</noscript>
    <script src="assets/js/jQuery_3.5.1.js"></script>
    <script src="assets/js/register.js"></script>
    <?php
        // When someone submit but make errors in register form
        // the page will remain on register form, and will not jump
        // to login form.
        if(isset($_POST['registerButton'])) {
            echo '<script>
            loginForm.style.display = "none";
            registerForm.style.display = "block";
            </script>';
        } else {
            echo '<script>
            loginForm.style.display = "block";
            registerForm.style.display = "none";
            </script>';
        }
    ?>

</body>
</html>