<?php

class Constants {

    public static $usernameNotValid = "Your username can only contain letters and numbers.";
    public static $usernameLength = "Your username must be between 5 and 25 characters.";
    public static $usernameTaken = "This username already exists.";
    public static $firstnameLength = "Your firstname must be between 2 and 25 characters.";
    public static $lastnameLength = "Your lastname must be between 2 and 25 characters.";
    public static $passwordNotMatch = "Your password don't match.";
    public static $passwordNotValid = "Your password must be between 8 and 25 characters, <br> must contain at least 1 number and 1 letter, <br> and may contain any of these characters: !.@#$%";
    public static $emailNotMatch = "Your email don't match.";
    public static $emailNotValid = "This email is invalid. Make sure it's written like <br> example@email.com";
    public static $emailTaken = "This email already exists.";
    public static $loginFailedUsername = "Your username or password was incorrect.";
    public static $loginFailedEmail = "Your email or password was incorrect.";

}

?>