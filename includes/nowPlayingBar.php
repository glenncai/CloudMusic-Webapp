<div id="nowPlayingBarContainer">
    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="alnumLink">
                    <img src="" id="albumArtworkShow" class="albumArtWork" alt="album">
                </span>

                <div class="trackInfo">
                    <span class="trackName">
                        <span id="TrackName"></span>
                        <span id="showLyrics">LYRICS</span>
                    </span>
                    <span class="artistName">
                        <span id="ArtistName"></span>
                        <button id="likeButton" title="Add to playlist">
                            <div id="unlike"></div>
                        </button>
                    </span>
                </div>
            </div>
        </div> <!-- left bar end -->

        <div id="nowPlayingCenter">
            <div class="content playerControl">

                <div class="buttons">

                    <button class="controlButton shuffle" title="Enable shuffle" style="visibility: hidden;" onclick="setShuffle()">
                        <img id="shuffleChangeActive" src="assets/images/icons/shuffle-active.png" alt="Shuffle">
                    </button>
                    <button class="controlButton shuffle" title="Enable shuffle" onclick="setShuffle()">
                        <img id="shuffleChange" src="assets/images/icons/shuffle.png" alt="Shuffle">
                    </button>
                    <button class="controlButton previous" title="Previous" onclick="previousSong()">
                        <img id="previousChange" src="assets/images/icons/previous.png" alt="Previous">
                    </button>  
                    <button class="controlButton play" title="Play" onclick="playSong()">
                        <img id="playChange" src="assets/images/icons/play.png" alt="Play">
                    </button>  
                    <button class="controlButton pause" title="Pause" style="display: none;" onclick="pauseSong()">
                        <img id="pauseChange" src="assets/images/icons/pause.png" alt="Pause">
                    </button> 
                    <button class="controlButton next" title="Next" onclick="nextSong()">
                        <img id="nextChange" src="assets/images/icons/next.png" alt="Next">
                    </button>  
                    <button class="controlButton repeat" title="Enable repeat" onclick="setRepeat()">
                        <img id="repeatChange" src="assets/images/icons/repeat.png" alt="Repeat">
                    </button>
                    <button class="controlButton repeatActive" title="Enable repeat" style="visibility: hidden;" onclick="setRepeat()">
                        <img id="repeatChangeActive" src="assets/images/icons/repeat-active.png" alt="Repeat">
                    </button>    

                </div> <!-- button end -->

                <div class="playbackBar">
                    <span class="progressTime" id="current">0.00</span>
                    <div class="progressBar" id="progressBarClick">
                        <div class="progressBarLine">
                            <div class="progress" id="progressMusic"></div>
                            <img src="assets/images/icons/circleProgress.png" id="circleProgress">
                        </div>
                    </div>
                    <span class="progressTime" id="remaining">0.00</span>
                </div> <!-- playbackBar end -->

            </div> <!-- playControl end -->
        </div> <!-- center end -->

        <div id="nowPlayingRight">
            <div class="volumeBar">

                <button class="controlButton volume" title="Volume button" onclick="setMuted()">
                    <img src="assets/images/icons/volume.png" id="volumeChange" alt="Volume">
                </button>
                <button class="controlButton volumeMuted" title="Volume button" style="visibility: hidden;" onclick="setMuted()">
                    <img src="assets/images/icons/volume-mute.png" id="volumeChangeActive" alt="Volume">
                </button>
                <div class="progressBar" id="volumeBarClick">
                    <div class="progressBarLine">
                        <div class="progress" id="progressVolume"></div>
                        <img src="assets/images/icons/circleProgress.png" id="circleVolume">
                    </div>
                </div>

            </div>
        </div> <!-- right bar end -->

    </div>
</div>

<?php
$resultArray = [];
$sql = "SELECT song_id FROM Songs ORDER BY RAND() LIMIT 10";
$stmt = $pdo->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch()) {
    array_push($resultArray, $row->song_id);
}

// change the PHP object to JSON type
$jsonArray = json_encode($resultArray);
?>

<script>
// For "DOMContentLoaded" in JavaScript, we can use $(document).ready(function() {}); to instead of it
// if we want to use jQuery

// After DOM loaded. this will execute
// Actually, if we put the whole js code blow the HTML DOM
// We don't need it. But I just try to use it.
window.addEventListener("DOMContentLoaded", function(event) {

    // This is newPlaylist array
    let newPlaylist = <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);

    // I put this function in here because when the page loaded that it will
    // be called. And the default volume is "1". Thus, when we refresh the 
    // page, the volume value will be set "1" automatically.
    updateVolumeProgressBar(audioElement.audio);

    // This two line  variable we need to put them in here
    // Because if we put in the script.js which is positioned at <head> tag (top)
    // it will cause that (Uncaught TypeError: Cannot read property 'addEventListener' of null)
    let progressBarClick = document.getElementById("progressBarClick");
    let mouseDown = false;

    progressBarClick.addEventListener("mousedown", function() {
        mouseDown = true;
    });

    progressBarClick.addEventListener("mousemove", function(event) {
        if(mouseDown) {
            // set time for song, dependent on position of mouse
            timeFromOffset(event, this);
        }
    });

    progressBarClick.addEventListener("mouseup", function(event) {
        // "this" refers to "progressBarClick"
        timeFromOffset(event, this);
    });

    // For valume bar
    let volumeBarClick = document.getElementById("volumeBarClick");

    volumeBarClick.addEventListener("mousedown", function() {
        mouseDown = true;
    });

    volumeBarClick.addEventListener("mousemove", function(event) {
        if(mouseDown) {

            let percentage = event.offsetX / volumeBarClick.offsetWidth;

            // the current volume of the audio/video. Must be a number between 0.0 and 1.0.
            if(percentage >= 0 && percentage <= 1) {
                audioElement.audio.volume = percentage;
            }
        }
    });

    volumeBarClick.addEventListener("mouseup", function(event) {
        let percentage = event.offsetX / volumeBarClick.offsetWidth;

        // the current volume of the audio/video. Must be a number between 0.0 and 1.0.
        if(percentage >= 0 && percentage <= 1) {
            audioElement.audio.volume = percentage;
        }
    });

    document.addEventListener("mouseup", function() {
        mouseDown = false;
    });

});

function setTrack(trackId, newPlaylist, play) {

    if(newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        // This one just copy the currentPlaylist to shufflePlaylist
        // But when the shufflePlaylist change, the original currentPlaylist will not be affected
        shufflePlaylist = currentPlaylist.slice();
        shuffleArray(shufflePlaylist);
    }

    if(shuffle == true) {
        currentIndexForSong = shufflePlaylist.indexOf(trackId);
        
    } else {
        currentIndexForSong = currentPlaylist.indexOf(trackId);
    }

    // We pause the song because if we don't, the song will playn immediately. 
    // We will then play the song later in the setTrack function if the play parameter is true.
    pauseSong();

    // "songId" is that specifies the data sent to the server along with the request.
    $.post("includes/handlers/ajax/getSongJson.php", {songId: trackId}, function(data) {

        // change Json string to Object
        let track = JSON.parse(data);

        // get the track name and edit it
        document.getElementById("TrackName").innerHTML = track.title;

        $.post("includes/handlers/ajax/getArtistJson.php", {artistId: track.artist_id}, function(data) {
            // change Json string to Object
            let artist = JSON.parse(data);
            document.getElementById("ArtistName").innerHTML = artist.name;
            document.getElementById("ArtistName").setAttribute("onclick", "openPage('artist.php?id=" + artist.artist_id + "')");
        });

        $.post("includes/handlers/ajax/getAlbumJson.php", {albumId: track.album_id}, function(data) {
            // change Json string to Object
            let album = JSON.parse(data);
            document.getElementById("albumArtworkShow").src = album.artworkPath;
            document.getElementById("albumArtworkShow").setAttribute("onclick", "openPage('album.php?id=" + album.album_id + "')");
            document.getElementById("TrackName").setAttribute("onclick", "openPage('album.php?id=" + album.album_id + "')");
        });

        // this setTrack function is from script.js
        // the track parameter is the object which is changed from JSON
        audioElement.setTrack(track);


        if(play == true) {
            playSong();
        }
    });


}

function playSong() {

    // ensure that when user play song, play count will increse 1
    // when user pause then play again the play count will not increase
    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", {songId: audioElement.currentlyPlaying.song_id});
    }

    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}

function pauseSong() {
    $(".controlButton.play").show();
    $(".controlButton.pause").hide();
    audioElement.pause();
}

function timeFromOffset(mouse, progressBar) {
    // "offsetX" is for the position of corresponding element, not the windows.
    let percentage = mouse.offsetX / progressBar.offsetWidth;
    let secondsTime = audioElement.audio.duration * percentage;
    audioElement.setTime(secondsTime);
}

function nextSong() {

    if(repeat == true) {
        audioElement.setTime(0);
        playSong();
        // we return in that if statement because 
        // we don't want to execute any other code from the function 
        // if we are playing the same song. 
        return;
    }

    // Because the random song is limit in 10, their index is 0 to 9
    // the length of currentPlaylist is 10
    // the maximum value of index is 9, the maximum of currentPlaylist is 10
    // when 9 = 10-1, it means that it will play the first song which index is 0
    if(currentIndexForSong == currentPlaylist.length - 1) {
        currentIndexForSong = 0;
    } else {
        currentIndexForSong++;
    }

    let trackPlayIdNow = shuffle ? shufflePlaylist[currentIndexForSong] : currentPlaylist[currentIndexForSong];
    setTrack(trackPlayIdNow, currentPlaylist, true);
}

function previousSong() {
    // For example, if user listen this song more than 3 seconds, when he/she click
    // previous button, the song will be replayed. This is the same behavior with Spotify
    if(audioElement.audio.currentTime >= 3 || currentIndexForSong == 0) {
        audioElement.setTime(0);
    } else {
        currentIndexForSong--;
        setTrack(currentPlaylist[currentIndexForSong], currentPlaylist, true);
    }
}

function setRepeat() {
    // If true, be false. If false, be true.
    repeat = !repeat;

    if(repeat) {
        repeatChange.style.visibility = "hidden";
        repeatChangeActive.style.visibility = "visible";
    } else {
        repeatChange.style.visibility = "visible";
        repeatChangeActive.style.visibility = "hidden";
    }
}

function setMuted() {
    // This will return true or false
    // If true, be false. If false, be true.
    audioElement.audio.muted = !audioElement.audio.muted;

    if(audioElement.audio.muted) {
        volumeChange.style.visibility = "hidden";
        volumeChangeActive.style.visibility = "visible";
    } else {
        volumeChange.style.visibility = "visible";
        volumeChangeActive.style.visibility = "hidden";
    }
}

function setShuffle() {
    // This will return true or false
    // If true, be false. If false, be true.
    shuffle = !shuffle;

    if(shuffle) {
        shuffleChange.style.visibility = "hidden";
        shuffleChangeActive.style.visibility = "visible";

        // Randomize playlist
        shuffleArray(shufflePlaylist);
        // Get the index for the corresponding song_id
        currentIndexForSong = shufflePlaylist.indexOf(audioElement.currentlyPlaying.song_id);
    } else {
        shuffleChange.style.visibility = "visible";
        shuffleChangeActive.style.visibility = "hidden";

        // shuffle has been deactived
        // go back to regular playlist

        // Get the index for the corresponding song_id
        currentIndexForSong = currentlyPlaying.indexOf(audioElement.currentlyPlaying.song_id);
    }
}

function shuffleArray(a) {
    for (let i = a.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [a[i], a[j]] = [a[j], a[i]];
    }
    return a;
}

</script>