<?php

include "../../db.php";

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    try {
        $playlistId = $_POST['playlistId'];
        $songId = $_POST['songId'];
    
        $sql_playlist = "DELETE FROM PlaylistsSongs WHERE playlist_id = :playlist_id AND song_id = :song_id";
        $sql_playlist = $pdo->prepare($sql_playlist);
        $sql_playlist->execute([
            ':playlist_id' => $playlistId,
            ':song_id' => $songId
        ]);
    } catch (Exception $ex) {
        echo("Internal error, please contact support");
        error_log("removeFromPlaylist.php, SQL error=" . $ex->getMessage());
    }
} 

?>