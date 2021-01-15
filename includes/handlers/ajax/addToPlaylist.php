<?php

include "../../db.php";

if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    try {
        $playlistId = $_POST['playlistId'];
        $songId = $_POST['songId'];

        // We make the order + 1 in order to let the song which is added to the bottom
        // If playlistOrder is null, we will use "1"
        $sql_order = "SELECT IFNULL(MAX(playlistOrder) + 1, 1) as playlistOrder FROM PlaylistsSongs WHERE playlist_id = :playlist_id";
        $stmt_order = $pdo->prepare($sql_order);
        $stmt_order->execute([
            ':playlist_id' => $playlistId
        ]);
        $row_order = $stmt_order->fetch();
        $order = $row_order->playlistOrder;

        $sql_add = "INSERT INTO PlaylistsSongs (song_id, playlist_id, playlistOrder) VALUES (:song_id, :playlist_id, :playlistOrder)";
        $stmt_add = $pdo->prepare($sql_add);
        $stmt_add->execute([
            ':song_id' => $songId,
            ':playlist_id' => $playlistId,
            ':playlistOrder' => $order
        ]);
    } catch (Exception $ex) {
        echo("Internal error, please contact support");
        error_log("addToPlaylist.php, SQL error=" . $ex->getMessage());
    }


}

?>