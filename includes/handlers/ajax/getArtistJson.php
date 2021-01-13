<?php

include "../../db.php";

// If "artistId" has been set
// "artistId" is from nowPlayingBar.php, it's name should be the same 
// with that one which is in nowPlayingBar.php
if(isset($_POST['artistId'])) {
    $artistId = $_POST['artistId'];

    $sql = "SELECT * FROM Artists WHERE artist_id = :artist_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':artist_id' => $artistId
    ]);
    $resultArray = $stmt->fetch();
    echo json_encode($resultArray);
}

?>