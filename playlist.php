<?php include "includes/includedFiles.php";

// Get the playlist id from yourLibrary.php
if(isset($_GET['id'])) {
    $playlistId = $_GET['id'];
} else {
    // If there is no existing this playlist, will be redirected to index
    header("Location: index.php");
}

// Because the second parameter is array, and the following one is variable (string)
// We will use is_array to determine and change it in Playlist.php
$playlist = new PlaylistID($pdo, $playlistId);
$owner = new User($pdo, $playlist->getOwner());

?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="assets/images/icons/playlist.png" alt="Playlist">
    </div>

    <div class="rightSectionPlaylist">
        <span class="playlistTitle"><?php echo $playlist->getName(); ?></span>
        <span class="playlistOwner">By <?php echo $playlist->getOwner(); ?></span>
        <span class="playlistText"><?php echo $playlist->getNumberOfSongs(); ?> songs</span>
        <button class="button playlistButton" onclick="deletePlaylist(<?php echo $playlistId; ?>)">DELETE PLAYLIST</button>
    </div>
</div>


<div class="tracklistContainer">

    <div class="trackTopTopContainer">
        <div class='trackTopPlay' onclick="playFirstSong()">
            <img id="trackTopPlayButton" src="assets/images/icons/bigPlayButton.png" alt="Play">
        </div>
    </div>

    <div class='trackTop'>
        <div class='trackLeft'>
            <span>#</span>
        </div>
        <div class='trackCenter'>
            <span>TITLE</span>
        </div>
        <div class='trackRight'>
            <img class='play' src='assets/images/icons/clock.png'>
        </div>
    </div>

    <ul class="tracklist">

        <?php

        $songIdArray = $playlist->getSongIds();

        // Set i is equal to 1, it is used for song list. e.g 1 2 3 4 5
        // If there are five songs total
        $i = 1;
        foreach($songIdArray as $songId) {
            
            $playlistSong  = new Song($pdo, $songId);
            $songArtist = $playlistSong->getArtistFromSong();

            echo "<li class='tracklistRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-song.png' onclick='setTrack(". $playlistSong->getId() . ", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>{$playlistSong->getTitle()}</span>
                        <span class='artistName'>{$songArtist->getName()}</span>
                    </div>
                    
                    <div class='trackLiked'>
                        <img class='optionButton' src='assets/images/icons/heart-white.png'>
                    </div>

                    <div class='trackDuration'>
                        <span class='duration'>{$playlistSong->getDuration()}</span>
                    </div>

                    <div class='trackOption'>
                        <input type='hidden' class='songId' value='{$playlistSong->getId()}'>
                        <img class='optionButton' src='assets/images/icons/more.png' onclick='showOptionMenu(this)'>
                    </div>
            </li>";
            $i++;

        }

        ?>

        <script>

            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);

        
            // For Playlist
            // Why I put here is because if I put in makeup.js, the addEventListener will be null. (no album.php in index)
            var trackTopPlayButton = document.getElementById("trackTopPlayButton");

            trackTopPlayButton.addEventListener("mouseover", mouseOver = () => {
                trackTopPlayButton.src = "assets/images/icons/bigPlayButton-grey.png";
            });

            trackTopPlayButton.addEventListener("mouseout", mouseOut = () => {
                trackTopPlayButton.src = "assets/images/icons/bigPlayButton.png";
            });

        </script>

    </ul>
</div>

<nav class="optionMenu">
    <!-- A hidden field let web developers include data that cannot be seen or modified by users when a form is submitted. -->
    <input type="hidden" class="songId">
    <div class="item" onclick="removeFromPlaylist(this, '<?php echo $playlistId ?>')">Remove from playlist</div>
</nav>


