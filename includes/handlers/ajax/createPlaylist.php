<?php

include "../../db.php";

if(isset($_POST['name']) && isset($_POST['username'])) {
    try {
        $name = $_POST['name'];
        $username = $_POST['username'];
        $date = date("Y-m-d");
    
        $sql_playlist = "INSERT INTO PlaylistsOwner (name, owner, dateCreated) VALUES (:name, :owner, :date)";
        $sql_playlist = $pdo->prepare($sql_playlist);
        $sql_playlist->execute([
            ':name' => $name,
            ':owner' => $username,
            ':date' => $date
        ]);
    } catch (Exception $ex) {
        echo("Internal error, please contact support");
        error_log("Song.php, SQL error=" . $ex->getMessage());
    }
} else {
    echo "Internal error, please contact support.";
}

?>