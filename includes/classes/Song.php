<?php

class Song {

    private $pdo;
    private $song_id;

    public function __construct($pdo, $song_id) {
        $this->pdo = $pdo;
        $this->song_id = $song_id;
    }

    public function getId() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT song_id FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->song_id;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getTitle() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT title FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->title;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getDuration() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT duration FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->duration;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getMusicAudio() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT path FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->path;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getPlayCount() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT plays FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->plays;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getLyrics() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT lyrics FROM Songs WHERE song_id = :song_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':song_id' => $this->song_id
            ]);
            $row = $stmt->fetch();
            return $row->lyrics;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getArtistFromSong() {
        try {
            // For foreign key
            // should get the corresponding artist_id first
            $pdo = $this->pdo;
            $sql_artistId = "SELECT artist_id FROM Songs WHERE song_id = :song_id";
            $stmt_artistId = $pdo->prepare($sql_artistId);
            $stmt_artistId->execute([
                ':song_id' => $this->song_id
            ]);
            $row_artistId = $stmt_artistId->fetch();
            $artist_id = $row_artistId->artist_id;
            return new Artist($pdo, $artist_id);
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getAlbumFromSong() {
        try {
            // For foreign key
            // should get the corresponding album_id first
            $pdo = $this->pdo;
            $sql_albumId = "SELECT album_id FROM Songs WHERE song_id = :song_id";
            $stmt_albumId = $pdo->prepare($sql_albumId);
            $stmt_albumId->execute([
                ':song_id' => $this->song_id
            ]);
            $row_albumId = $stmt_albumId->fetch();
            $album_id = $row_albumId->album_id;
            return new Album($pdo, $album_id);
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }

    public function getGenreFromSong() {
        try {
            // For foreign key
            // should get the corresponding album_id first
            $pdo = $this->pdo;
            $sql_genreId = "SELECT genre_id FROM Songs WHERE song_id = :song_id";
            $stmt_genreId = $pdo->prepare($sql_genreId);
            $stmt_genreId->execute([
                ':song_id' => $this->song_id
            ]);
            $row_genreId = $stmt_genreId->fetch();
            $genre_id = $row_genreId->genre_id;
            return new Genre($pdo, $genre_id);
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Song.php, SQL error=" . $ex->getMessage());
        }
    }


}


?>