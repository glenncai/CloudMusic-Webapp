<?php
include "includes/includedFiles.php";
?>

<div class="userDetails">

    <div class="container borderBottom userInfo">
        <img src="<?php echo $userLoggedIn->getUserPic(); ?>">
    </div>

    <div class="container borderBottom">
        <h2>EMAIL</h2>
        <input type="text" class="email" name="email" id="email" placeholder="Your email address" value="<?php echo $userLoggedIn->getEmail(); ?>">
        <span class="message"></span>
        <button class="buttonSetting" onclick="updateEmail('email')">UPDATE</button>
    </div>

    <div class="container">
        <h2>PASSWORD</h2>
        <input type="password" class="oldPassword" name="oldPassword" id="oldPassword" placeholder="Current password">
        <input type="password" class="newPassword1" name="newPassword1" id="newPassword1" placeholder="New password">
        <input type="password" class="newPassword2" name="newPassword2" id="newPassword2" placeholder="Confirm new password">
        <span class="message"></span>
        <button class="buttonSetting" onclick="updatePassword('oldPassword','newPassword1','newPassword2')">UPDATE</button>
    </div>

</div>