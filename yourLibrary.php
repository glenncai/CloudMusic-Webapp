<?php

include "includes/includedFiles.php";

?>

<div class="libraryContainer">

    <div class="libraryViewContainer">

        <h1>PLAYLISTS</h1>

        <div class="buttonItems">
            <button class="button green" onclick="createPlaylist()">NEW PLAYLIST</button>
        </div>

        <?php

            $username = $userLoggedIn->getUsername();

            $sql = "SELECT * FROM PlaylistsOwner WHERE owner = :owner";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':owner' => $username
            ]);

            $countPlaylist = $stmt->rowCount();
            if($countPlaylist == 0) {
                echo "<div class='messageContainer'>
                        <img class='playlistCD' src='assets/images/icons/cd.png'>
                        <span class='playListMessageTop'>It's a bit empty here...</span>
                        <span class='playListMessageBottom'>Let's find some songs for your playlist</span>
                </div>";
            }

            while($row = $stmt->fetch()) {

                $playlist = new Playlist($pdo, $row);

                echo "<div class='gridViewItem' onclick='openPage(\"playlist.php?id={$playlist->getId()}\")'>

                        <div class='playlistImage'>
                            <img src='assets/images/icons/playlist.png'>
                        </div>

                        <div class='playlistInfo'>
                            {$playlist->getName()}
                        </div>
                </div>";

            }

        ?>

    </div>

</div>