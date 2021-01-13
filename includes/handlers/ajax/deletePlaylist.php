<?php

include "../../db.php";

if(isset($_POST['playlist_id'])) {
    try {
        $playlist_id = $_POST['playlist_id'];
    
        $sql = "DELETE FROM PlaylistsOwner WHERE id = :playlist_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':playlist_id' => $playlist_id
        ]);

        $sql_delete = "DELETE FROM PlaylistsSongs WHERE playlist_id = :playlist_id";
        $stmt_delete = $pdo->prepare($sql);
        $stmt->execute([
            ':playlist_id' => $playlist_id
        ]);
    } catch (Exception $ex) {
        echo("Internal error, please contact support");
        error_log("deletePlaylist.php, SQL error=" . $ex->getMessage());
    }
} else {
    echo "Internal error, please contact support.";
}

?>