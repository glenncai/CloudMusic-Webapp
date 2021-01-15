<?php

include "includes/db.php";
include "includes/classes/User.php";
include "includes/classes/Genre.php";
include "includes/classes/Artist.php";
include "includes/classes/Album.php";
include "includes/classes/Song.php";
include "includes/classes/Playlist.php";
include "includes/classes/PlaylistID.php";

// Determine whether userLoggedIn exists in SESSION
// If exists, stay in index.php, otherwise rediected to register page
if(isset($_SESSION['userLoggedIn'])) {
    $userLoggedIn = $_SESSION['userLoggedIn'];
    echo "<script>userLoggedIn = '$userLoggedIn';</script>";
} else {
    header("Location: register.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/jQuery_3.5.1.js"></script>
    <script src="assets/js/script.js"></script>
    <title>Cloud Music</title>
</head>
<body>

    <noscript>Your browser does not support JavaScript!</noscript>
    
    <div id="mainContainer">

        <div id="topContainer">

            <?php include "includes/navBarContainer.php"; ?>

            <div id="mainViewContainer">

                <div id="profileContainer">
                    <div id="profileContainerItem">
                        <div class="previous__next">
                            <span id="prevPage"><img src="assets/images/icons/prevPage.png" alt="Next page"></span>
                            <span id="nextPage"><img src="assets/images/icons/nextPage.png" alt="Prev page"></span>
                        </div>
                        <div id="profileInfo">

                            <?php

                            $sql_user = "SELECT * FROM users WHERE username = :username";
                            $stmt_user = $pdo->prepare($sql_user);
                            $stmt_user->execute([
                                ':username' => $userLoggedIn
                            ]);
                            $row_user = $stmt_user->fetch();

                            ?>

                            <div id="personalInfo">
                                <span id="personalInfoText"><?php echo $row_user->firstname; ?> <?php echo $row_user->lastname; ?></span>
                                <img src="<?php echo $row_user->profilePic; ?>">
                            </div>

                        </div>
                    </div>
                </div>

                <div id="mainContent">