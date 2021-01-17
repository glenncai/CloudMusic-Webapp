<?php
include "includes/includedFiles.php";
?>

<div class="entityInfoSetting">

    <div class="centerSection">
        <div class="settingInfo">
            <img src="<?php echo $userLoggedIn->getUserPic(); ?>">
            <h1><?php echo $userLoggedIn->getFirstnameAndLastname(); ?></h1>
        </div>
    </div>

    <div class="buttonItems">
        <button class="buttonSetting" onclick="openPage('userDetails.php')">USER DETAILS</button>
        <button class="buttonSetting" onclick="logout()">LOGOUT</button>
    </div>

</div>