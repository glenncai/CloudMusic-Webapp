<?php

include "../../db.php";

// If "songId" has been set
// "songId" is from nowPlayingBar.php, it's name should be the same 
// with that one which is in nowPlayingBar.php
if(isset($_POST['songId'])) {
    $songId = $_POST['songId'];

    $sql = "SELECT * FROM Songs WHERE song_id = :song_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':song_id' => $songId
    ]);
    $resultArray = $stmt->fetch();
    echo json_encode($resultArray);
}

?>