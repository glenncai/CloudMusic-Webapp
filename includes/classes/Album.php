<?php

class Album {

    private $pdo;
    private $album_id;

    public function __construct($pdo, $album_id) {
        $this->pdo = $pdo;
        $this->album_id = $album_id;
    }

    public function getTitle() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT title FROM Albums WHERE album_id = :album_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id' => $this->album_id
            ]);
            $row = $stmt->fetch();
            return $row->title;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getDescription() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT album_description FROM Albums WHERE album_id = :album_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id' => $this->album_id
            ]);
            $row = $stmt->fetch();
            return $row->album_description;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtwork() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT artworkPath FROM Albums WHERE album_id = :album_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id' => $this->album_id
            ]);
            $row = $stmt->fetch();
            return $row->artworkPath;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistId() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT artist_id FROM Albums WHERE album_id = :album_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id' => $this->album_id
            ]);
            $row = $stmt->fetch();
            return $row->artist_id;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistFromAlbum() {
        try {
            // For foreign key
            // should get the corresponding artist_id first
            $pdo = $this->pdo;
            $sql_artistId = "SELECT artist_id FROM Albums WHERE album_id = :album_id";
            $stmt_artistId = $pdo->prepare($sql_artistId);
            $stmt_artistId->execute([
                ':album_id' => $this->album_id
            ]);
            $row_artistId = $stmt_artistId->fetch();
            $artist_id = $row_artistId->artist_id;
            return new Artist($pdo, $artist_id);
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getGenreFromAlbum() {
        try {
            // For foreign key
            // should get the corresponding artist_id first
            $pdo = $this->pdo;
            $sql_genreId = "SELECT genre_id FROM Albums WHERE album_id = :album_id";
            $stmt_genreId = $pdo->prepare($sql_genreId);
            $stmt_genreId->execute([
                ':album_id' => $this->album_id
            ]);
            $row_genreId = $stmt_genreId->fetch();
            $genre_id = $row_genreId->genre_id;
            return new Genre($pdo, $genre_id);
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getNumberOfSongs() {
        try {
            $pdo = $this->pdo;
            $sql_song = "SELECT song_id FROM Songs WHERE album_id = :album_id";
            $stmt_song = $pdo->prepare($sql_song);
            $stmt_song->execute([
                ':album_id' => $this->album_id
            ]);
            $songCount = $stmt_song->rowCount();
            return $songCount;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getSongIds() {
        try {
            // Because one album_id is corresponding to many
            // different song_id, we should use array to store them
            $pdo = $this->pdo;
            $array = array();
            $sql = "SELECT song_id FROM Songs WHERE album_id = :album_id ORDER BY plays DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':album_id' => $this->album_id
            ]);
            while($row = $stmt->fetch()) {
                array_push($array, $row->song_id);
            }
            return $array;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Album.php, SQL error=" . $ex->getMessage());
        }

    }

}

?>