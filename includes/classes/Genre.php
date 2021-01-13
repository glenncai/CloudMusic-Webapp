<?php  

class Genre {

    private $pdo;
    private $genre_id;

    public function __construct($pdo, $genre_id) {
        $this->pdo = $pdo;
        $this->genre_id = $genre_id;
    }

    public function getName() {
        try {
            $pdo = $this->pdo;
            $sql = "SELECT name FROM Genres WHERE genre_id = :genre_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':genre_id' => $this->genre_id
            ]);
            $row = $stmt->fetch();
            return $row->name;
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("Genre.php, SQL error=" . $ex->getMessage());
        }
    }

}

?>