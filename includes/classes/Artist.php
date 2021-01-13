<?php

class Artist {

    private $pdo;
    private $artist_id;

    public function __construct($pdo, $artist_id) {
        $this->pdo = $pdo;
        $this->artist_id = $artist_id;
    }

    public function getId() {
        try {
            $pdo = $this->pdo;
            $sql_artist = "SELECT artist_id FROM Artists WHERE artist_id = :artist_id";
            $stmt_artist = $pdo->prepare($sql_artist);
            $stmt_artist->execute([
                ':artist_id' => $this->artist_id
            ]);
            $row_artist = $stmt_artist->fetch();
            return $row_artist->artist_id;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getName() {
        try {
            $pdo = $this->pdo;
            $sql_artist = "SELECT name FROM Artists WHERE artist_id = :artist_id";
            $stmt_artist = $pdo->prepare($sql_artist);
            $stmt_artist->execute([
                ':artist_id' => $this->artist_id
            ]);
            $row_artist = $stmt_artist->fetch();
            return $row_artist->name;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistPic() {
        try {
            $pdo = $this->pdo;
            $sql_artistPic = "SELECT artistPic FROM Artists WHERE artist_id = :artist_id";
            $stmt_artistPic = $pdo->prepare($sql_artistPic);
            $stmt_artistPic->execute([
                ':artist_id' => $this->artist_id
            ]);
            $row_artistPic = $stmt_artistPic->fetch();
            return $row_artistPic->artistPic;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistBackground() {
        try {
            $pdo = $this->pdo;
            $sql_artistBackground = "SELECT backgroundPic FROM Artists WHERE artist_id = :artist_id";
            $stmt_artistBackground = $pdo->prepare($sql_artistBackground);
            $stmt_artistBackground->execute([
                ':artist_id' => $this->artist_id
            ]);
            $row_artistBackground = $stmt_artistBackground->fetch();
            return $row_artistBackground->backgroundPic;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistCountry() {
        try {
            $pdo = $this->pdo;
            $sql_artistCountry = "SELECT country FROM Artists WHERE artist_id = :artist_id";
            $stmt_artistCountry = $pdo->prepare($sql_artistCountry);
            $stmt_artistCountry->execute([
                ':artist_id' => $this->artist_id
            ]);
            $row_artistCountry = $stmt_artistCountry->fetch();
            return $row_artistCountry->country;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getSongIdFromArtist() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT song_id FROM Songs WHERE artist_id = :artist_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':artist_id' => $this->artist_id
            ]);
            $array = [];
            while($row = $stmt->fetch()) {
                array_push($array, $row->song_id);
            }
            return $array;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Artist.php, SQL error=" . $ex->getMessage());
        }
    }

}

?>