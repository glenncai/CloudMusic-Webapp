<?php

include "includes/includedFiles.php";

if(isset($_GET['id'])) {
    $artist_id = $_GET['id'];
} else {
    header("Location: index.php");
}

$artist = new Artist($pdo, $artist_id);

?>

<div class="entityInfoArtist">

    <div class="centerSection">

        <div class="artistInfo">

            <img class="artist__pic" src="<?php echo $artist->getArtistPic(); ?>">
            <h1 class="artist__Name"><?php echo $artist->getName(); ?></h1>
            <h4 class="artist_country"><?php echo $artist->getArtistCountry(); ?></h4>
            <div class="headerButtons">
                <button class="button" onclick="playFirstSong()">PLAY</button>
            </div>

        </div>

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

<div class="borderBottom">
    <h2>POPULAR</h2>
    <ul class="tracklist">

        <?php

        $songIdArray = $artist->getSongIdFromArtist();

        // Set i is equal to 1, it is used for song list. e.g 1 2 3 4 5
        // If there are five songs total
        $i = 1;
        foreach($songIdArray as $songId) {

            // Maximum song is 5
            if($i > 5) {
                break;
            }
            
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
                        <input type='hidden' class='songId' value='{$albumSong->getId()}'>
                        <img class='optionButton' src='assets/images/icons/more.png' onclick='showOptionMenu(this)'>
                    </div>
                </li>";
            $i++;

        }

        ?>

        <script>

            var tempSongIdsArray = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIdsArray);
            
        </script>

    </ul>
</div>

<div class="gridViewContainer">
    <h2>ALBUM</h2>
    <?php
        try {
            $sql = "SELECT * FROM Albums WHERE artist_id = :artist_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':artist_id' => $artist_id
            ]);
            while($row = $stmt->fetch()) {
                
                echo "<div class='gridViewItem'>
                        <span onclick='openPage(\"album.php?id={$row->album_id}\")'>
                        <div class='gridViewInside'>
                            <img id='albumButton' class='albumEffectShow' src='assets/images/icons/bigPlayButton.png'>
                            <img src='{$row->artworkPath}'>
                            <span class='textOverName'><p class='gridViewInfo'>{$row->title}</p></span>
                            <span class='textOverInfo'><p class='gridViewDes'>{$row->album_description}</p></span>
                        </div>
                        </span>
                </div>";
            }
        } catch (Exception $ex) {
            echo("Internal error, please contact support");
            error_log("artist.php, SQL error=" . $ex->getMessage());
        }
    ?>

</div>

<nav class="optionMenu">
    <!-- A hidden field let web developers include data that cannot be seen or modified by users when a form is submitted. -->
    <input type="hidden" class="songId">
    <?php echo PlaylistID::getPlaylistDropdown($pdo, $userLoggedIn->getUsername()); ?>
    <div class="item">Add to love song</div>
    <div class="item">Share to Twitter</div>
    <div class="item">Share to Facebook</div>
</nav>