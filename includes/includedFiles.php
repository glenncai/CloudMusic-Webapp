<?php

if(isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
    include "includes/db.php";
    include "includes/classes/User.php";
    include "includes/classes/Genre.php";
    include "includes/classes/Artist.php";
    include "includes/classes/Album.php";
    include "includes/classes/Song.php";
    include "includes/classes/Playlist.php";
    include "includes/classes/PlaylistID.php";

    // This is from encodedUrl which is in script.js
    if(isset($_GET['userLoggedIn'])) {
        $userLoggedIn = new User($pdo, $_GET['userLoggedIn']);
    } else {
        echo "Internal error, please contact support.";
        exit();
    }

} else {
    include "includes/header.php";
    include "includes/footer.php";

    // The URI which was given in order to access this page; for instance, '/index.html'.
    $url = $_SERVER['REQUEST_URI'];
    echo "<script>openPage('$url')</script>";
    exit();
}

?>