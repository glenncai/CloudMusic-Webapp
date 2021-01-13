<?php include "includes/includedFiles.php";


// Get the album id from url link
// Because it will be printed by index.php <a> tag
if(isset($_GET['id'])) {
    $album_id = $_GET['id'];
} else {
    // If there is no existing this album, will be redirected to index
    header("Location: index.php");
}

$album = new Album($pdo, $album_id);
$artist = $album->getArtistFromAlbum();
$genre = $album->getGenreFromAlbum();

?>

<div class="entityInfo">
    <div class="leftSection">
        <img src="<?php echo $album->getArtwork(); ?>" alt="Album Picture">
    </div>

    <div class="rightSection">
        <span>ALBUM</span>
        <span class="albumTitle"><?php echo $album->getTitle(); ?></span>
        <span class="albumDescription"><?php echo $album->getDescription(); ?></span>
        <div class="albumInfo">
            <a class="artistTextLink" onclick="openPage('artist.php?id=<?php echo $album->getArtistId(); ?>')">
            <span class="artistTextColor"><?php echo $artist->getName(); ?></a></span>
            <span class="albumText">･</span>
            <span class="albumText"><?php echo $album->getNumberOfSongs(); ?> songs</span>
            <span class="albumText">･</span>
            <span class="albumText"><?php echo $genre->getName(); ?></span>
        </div>
    </div>
</div>

<div class="tracklistContainer">

    <div class="trackTopTopContainer">
        <div class='trackTopPlay' onclick="playFirstSong()">
            <img id="trackTopPlayButton" src="assets/images/icons/bigPlayButton.png" alt="Play">
        </div>
        <div class='trackTopLike'>
            <img id="trackTopLikeButton" src="assets/images/icons/heart.png" alt="Play">
        </div>
        <div class='trackTopMore'>
            <img id="trackTopMoreButton" src="assets/images/icons/more-grey.png" alt="Play">
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

        $songIdArray = $album->getSongIds();

        // Set i is equal to 1, it is used for song list. e.g 1 2 3 4 5
        // If there are five songs total
        $i = 1;
        foreach($songIdArray as $songId) {
            
            $albumSong  = new Song($pdo, $songId);
            $albumArtist = $albumSong->getArtistFromSong();

            echo "<li class='tracklistRow'>
                    <div class='trackCount'>
                        <img class='play' src='assets/images/icons/play-song.png' onclick='setTrack(". $albumSong->getId() . ", tempPlaylist, true)'>
                        <span class='trackNumber'>$i</span>
                    </div>

                    <div class='trackInfo'>
                        <span class='trackName'>{$albumSong->getTitle()}</span>
                        <span class='artistName'>{$albumArtist->getName()}</span>
                    </div>
                    
                    <div class='trackLiked'>
                        <img class='optionButton' src='assets/images/icons/heart-white.png'>
                    </div>

                    <div class='trackDuration'>
                        <span class='duration'>{$albumSong->getDuration()}</span>
                    </div>

                    <div class='trackOption'>
                        <img class='optionButton' src='assets/images/icons/more.png'>
                    </div>
                </li>";
            $i++;

        }

        ?>

        <script>

            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);

        
            // Foe album
            // Why I put here is because if I put in makeup.js, the addEventListener will be null. (no album.php in index)
            var trackTopPlayButton = document.getElementById("trackTopPlayButton");
            var trackTopMoreButton = document.getElementById("trackTopMoreButton");

            trackTopPlayButton.addEventListener("mouseover", mouseOver = () => {
                trackTopPlayButton.src = "assets/images/icons/bigPlayButton-grey.png";
            });

            trackTopPlayButton.addEventListener("mouseout", mouseOut = () => {
                trackTopPlayButton.src = "assets/images/icons/bigPlayButton.png";
            });

            trackTopMoreButton.addEventListener("mouseover", mouseOver = () => {
                trackTopMoreButton.src = "assets/images/icons/more.png";
            });

            trackTopMoreButton.addEventListener("mouseout", mouseOut = () => {
                trackTopMoreButton.src = "assets/images/icons/more-grey.png";
            });

        </script>

    </ul>
</div>



