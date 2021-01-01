<?php
include "includes/classes/Constants.php";
include "includes/classes/Account.php";

$account = new Account();

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
    <title>Cloud Music</title>
</head>
<body>
    <div class="inputContainer">
        <form action="register.php" id="loginForm" method="POST">
            <h2>To continue, log in to Cloud Music</h2>
            <p>
                <label for="loginUsername">Email address or username</label>
                <input type="text" id="loginUsername" name="loginUsername" placeholder="Email address or username." required>
            </p>
            <p>
                <label for="loginPassword">Password</label>
                <input type="password" id="loginPassword" name="loginPassword" placeholder="Password." required>
            </p>
            <button type="submit" name="loginButton">LOG IN</button>
        </form>

        <form action="register.php" id="registerForm" method="POST">
            <h2>Sign up for free to start listening.</h2>
            <p>
                <label for="regUsername">Username</label>
                <input type="text" id="regUsername" name="regUsername" placeholder="Enter your username." value="<?php keepValueLastTime('regUsername'); ?>" required>
                <?php echo $account->getError(Constants::$usernameLength); ?>
                <?php echo $account->getError(Constants::$usernameNotValid); ?>
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
            <button type="submit" name="registerButton">SIGN UP</button>
        </form>
    </div>
</body>
</html>