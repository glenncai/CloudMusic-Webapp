<?php

include "../../db.php";

// If "albumId" has been set
// "albumId" is from nowPlayingBar.php, it's name should be the same 
// with that one which is in nowPlayingBar.php
if(isset($_POST['albumId'])) {
    $albumId = $_POST['albumId'];

    $sql = "SELECT * FROM Albums WHERE album_id = :album_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':album_id' => $albumId
    ]);
    $resultArray = $stmt->fetch();
    echo json_encode($resultArray);
}

?>