let currentPlaylist = [];
let shufflePlaylist = [];
let tempPlaylist = [];
let audioElement;
let currentIndexForSong = 0;
let repeat = false;
let shuffle = false;

var timer;

// declare as windows object
var userLoggedIn;

function openPage(url) {

	// Fixed bug
	if(timer != null) {
		// stop operation when someone is typing then
		// click other page immediately
		clearTimeout(timer);
	}

	// If not exist
	if(url.indexOf("?") == -1) {
		url = url + "?";
	}

	let encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
	$("#mainContent").load(encodedUrl);
	$("body").scrollTop(0);
	history.pushState(null, null, url);
}

function createPlaylist() {

	let inputPlaylistName = prompt("Please enter your new playlist name:");

	// prevent user from entering empty name for playlist
	if(inputPlaylistName != null) {

		$.post("includes/handlers/ajax/createPlaylist.php", {name: inputPlaylistName, username: userLoggedIn})
		.done(function(error) {
			// do something when ajax returns

			// If there exitsing error message
			if(error != "") {
				alert(error);
				return;
			}

			openPage("createPlaylist.php");
		});
	}
}

function deletePlaylist(playlistId) {

	let prompt = confirm("Are you sure to delete this playlist?");

	if(prompt) {
		$.post("includes/handlers/ajax/deletePlaylist.php", {playlist_id: playlistId})
		.done(function(error) {
			// do something when ajax returns

			// If there exitsing error message
			if(error != "") {
				alert(error);
				return;
			}

			openPage("deletePlaylist.php");
		});
	}

}

function formatTime(secondsTime) {
	let time = Math.round(secondsTime);
	let minutes = Math.floor(time / 60); // i.e. 5.45 will be 5
	let seconds = time - (minutes * 60);

	// If the second time is single like 4:4
	// we wanna it be 4:04
	let extraZero = (seconds < 10) ? "0" : "";

	return minutes + ":" + extraZero +seconds;
}

function updateTimeProgressBar(audioElement) {
	// current time increase
	document.getElementById("current").innerHTML = formatTime(audioElement.currentTime);
	// remaining time decrease
	document.getElementById("remaining").innerHTML = formatTime(audioElement.duration - audioElement.currentTime);

	// For music progress increase, we want the percentage format
	let progressMusic = audioElement.currentTime / audioElement.duration * 100;
	document.getElementById("progressMusic").style.width = progressMusic + "%";

	// The is for the circle button
	// -2 just keep the postion to left a littile
	document.getElementById("circleProgress").style.left = progressMusic - 2 + "%";
}

function updateVolumeProgressBar(audioElement) {
	// Because volume value must between 0.0 and 1.0, we need to mutipy 100
	// width is 100%. i.e when value is 0.5, it will be 50%
	let progressVolume = audioElement.volume * 100;
	document.getElementById("progressVolume").style.width = progressVolume + "%"; 
	document.getElementById("circleVolume").style.left = progressVolume - 2 + "%";
}

function playFirstSong() {
	setTrack(tempPlaylist[0], tempPlaylist, true);
}

// For play song
function Audio() {

	this.currentlyPlaying;
	// create a <audio> HTML tag
	this.audio = document.createElement('audio');

	this.audio.addEventListener("canplay", function() {
		// "this" refers to the object that the event was called on (this.audio)
		let duration = formatTime(this.duration);
		document.getElementById("remaining").innerHTML = duration;
	});

	this.audio.addEventListener("timeupdate", function() {
		// If audio.duration exist
		if(this.duration) {
			// "this" refer to "this.audio"
			updateTimeProgressBar(this);
		}
	});

	// When the song is ended, it will play the next song automatically
	this.audio.addEventListener("ended", function() {
		nextSong();
	});

	this.audio.addEventListener("volumechange", function() {
		// "this" refer to "this.audio"
		updateVolumeProgressBar(this);
	});

	// the track parameter is object
	this.setTrack = function(track) {
		this.currentlyPlaying = track;
		this.audio.src = track.path;
	}

	this.play = function() {
        // This "audio" is from script.js which is "this.audio" for <audio> tag
		this.audio.play();
    }
    
    this.pause = function() {
        this.audio.pause();
	}
	
	this.setTime = function(secondsTime) {
		this.audio.currentTime = secondsTime;
	}

}
