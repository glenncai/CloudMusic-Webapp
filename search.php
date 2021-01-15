<?php

include "includes/includedFiles.php";

if(isset($_GET['term'])) {
    // urldecode => e.g https%3A%2F%2Fide.geeksforgeeks.org%2F" will changed to be https://ide.geeksforgeeks.org/
    $term = urldecode($_GET['term']);
} else {
    $term = "";
}

?>

<div class="searchContainer">

    <input type="text" class="searchInput" id="searchInputValue" value="<?php echo $term; ?>" placeholder="Search for Artists, Songs, or Albums" 
    onfocus="var val=this.value; this.value=''; this.value= val;" autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" >

</div>

<script>

    var searchInputValue = document.getElementById("searchInputValue");
    //The clearTimeout() method can cancel the timing operation set by the setTimeout() method.
    searchInputValue.addEventListener("keyup", function() {
        // Keep one output
        clearTimeout(timer);

        timer = setTimeout(function() {
            var inputValue = searchInputValue.value;
            openPage("search.php?term=" + inputValue);
        }, 1000);
    });

    searchInputValue.focus();

</script>

<?php 
    if($term == "") {
        exit();
    } 
?>


<div class="borderBottom">
    <h2>SONGS</h2>
    <ul class="tracklist">

        <?php

        $term = "$term%";
        $songQuery = "SELECT song_id FROM Songs WHERE title LIKE :term";
        $stmt_song = $pdo->prepare($songQuery);
        $stmt_song->bindParam(':term', $term);
        $stmt_song->execute([$term]);

        $countSong = $stmt_song->rowCount();
        if($countSong == 0) {
            echo "<span class='noResults'>Sorry, no songs found matching...</span>";
        }

        $songIdArray = [];

        // Set i is equal to 1, it is used for song list. e.g 1 2 3 4 5
        // If there are five songs total
        $i = 1;
        while($row = $stmt_song->fetch()) {

            // Maximum song is 5
            if($i > 15) {
                break;
            }

            array_push($songIdArray, $row->song_id);
            
            $albumSong  = new Song($pdo, $row->song_id);
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

<div class="artistsContainer borderBottom">

        <h2>ARTISTS</h2>

        <?php

            $artistQuery = "SELECT artist_id FROM Artists WHERE name LIKE :term LIMIT 10";
            $stmt_artist = $pdo->prepare($artistQuery);
            $stmt_artist->bindParam(':term', $term);
            $stmt_artist->execute([$term]);
    
            $countArtist = $stmt_artist->rowCount();
            if($countArtist == 0) {
                echo "<span class='noResults'>Sorry, no artists found matching...</span>";
            }

            while($row = $stmt_artist->fetch()) {
                $artistFound = new Artist($pdo, $row->artist_id);

                echo "<div class='artistViewItem'>
                        <span onclick='openPage(\"artist.php?id={$artistFound->getId()}\")'>
                            <div class='artistViewInside'>
                                <img id='artistPicSearch' src='{$artistFound->getArtistPic()}'>
                                <span class='textOverName'><p class='gridViewInfo'>{$artistFound->getName()}</p></span>
                            </div>
                        </span>
                </div>";
            }

        ?>

</div>

<div class="gridViewContainer">
    <h2>ALBUMS</h2>
    <?php

        $albumQuery = "SELECT * FROM Albums WHERE title LIKE :term LIMIT 10";
        $stmt_album = $pdo->prepare($albumQuery);
        $stmt_album->bindParam(':term', $term);
        $stmt_album->execute([$term]);

        $countAlbum = $stmt_album->rowCount();
        if($countAlbum == 0) {
            echo "<span class='noResults'>Sorry, no albums found matching...</span>";
        }

        while($row = $stmt_album->fetch()) {
            $albumFound = new Album($pdo, $row->album_id);

            echo "<div class='gridViewItem'>
                    <span onclick='openPage(\"album.php?id={$row->album_id}\")'>
                    <div class='gridViewInside'>
                        <img id='albumButton' class='albumEffectShow' src='assets/images/icons/bigPlayButton.png'>
                        <img src='{$row->artworkPath}'>
                        <span class='textOverName'><p class='gridViewInfo'>{$row->title}</p></span>
                    </div>
                    </span>
            </div>";
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