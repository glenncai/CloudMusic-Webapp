<?php

class PlaylistID {

    private $pdo;
    private $id;

    public function __construct($pdo, $id) {

        $this->pdo = $pdo;
        $this->id = $id;
    }

    public function getName() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT name FROM PlaylistsOwner WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id
            ]);
            $row = $stmt->fetch();
            return $row->name;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("PlaylistID.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getOwner() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT owner FROM PlaylistsOwner WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id' => $this->id
            ]);
            $row = $stmt->fetch();
            return $row->owner;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("PlaylistID.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getNumberOfSongs() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT song_id FROM PlaylistsSongs WHERE playlist_id = :playlist_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':playlist_id' => $this->id
            ]);
            $count = $stmt->rowCount();
            return $count;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("PlaylistID.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getSongIds() {
        try {
            $pdo = $this->pdo;
            $array = [];
            $sql = "SELECT song_id FROM PlaylistsSongs WHERE playlist_id = :playlist_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':playlist_id' => $this->id
            ]);
            while($row = $stmt->fetch()) {
                array_push($array, $row->song_id);
            }
            return $array;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("PlaylistID.php, SQL error=" . $ex->getMessage());
        }
    }

}

?>