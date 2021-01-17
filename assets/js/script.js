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

// When user click empty, the option menu will disappear
$(document).click(function(click) {
	let target = $(click.target);

	if(!target.hasClass("item") && !target.hasClass("optionButton")) {
		hideOptionMenu();
	}
});

// When the user scrolls the specified element, the scroll event occurs.
$(window).scroll(function() {
	hideOptionMenu();
});

// The on() method adds one or more event handlers to the selected element and child elements.
$(document).on("change", "select.playlist", function() {
	let select = $(this);
	let playlistId = select.val();
	let songId = select.prev(".songId").val();

	$.post("includes/handlers/ajax/addToPlaylist.php", {playlistId:playlistId, songId:songId})
	.done(function(error) {

		if(error != "") {
			alert(error);
			return;
		}

		hideOptionMenu();

		// When we finished selection, we will return to original which is <option value="">Add to playlist</option>
		// The value is ""
		select.val("");
	});
});

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

function logout() {
	$.post("includes/handlers/ajax/logout.php", function() {
		window.location.reload();
	});
}

function removeFromPlaylist(button, playlistId) {
	let songId = $(button).prevAll(".songId").val();

	$.post("includes/handlers/ajax/removeFromPlaylist.php", {playlistId: playlistId, songId: songId})
	.done(function(error) {
		// do something when ajax returns

		// If there exitsing error message
		if(error != "") {
			alert(error);
			return;
		}

		openPage("playlist.php?id=" + playlistId);
	});
}

function updateEmail(email) {
	let emailValue = $("." + email).val();

	$.post("includes/handlers/ajax/updateEmail.php", {email: emailValue, username: userLoggedIn})
	.done(function(response) {
		$("." + email).nextAll(".message").text(response);
	});

}

function updatePassword(oldPasswordClass, newPassword1Class, newPassword2Class) {
	let oldPassword = $("." + oldPasswordClass).val();
	let newPassword1 = $("." + newPassword1Class).val();
	let newPassword2 = $("." + newPassword2Class).val();

	$.post("includes/handlers/ajax/updatePassword.php", 
	{oldPassword: oldPassword, newPassword1: newPassword1, newPassword2: newPassword2, username: userLoggedIn})
	.done(function(response) {
		// change the text result
		$("." + oldPasswordClass).nextAll(".message").text(response);
	});

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

			openPage("yourLibrary.php");
			// refresh the whole page in order to update the nav bar playlist item
			window.location.reload();
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

			openPage("yourLibrary.php");
			// refresh the whole page in order to update the nav bar playlist item
			window.location.reload();
		});
	}

}

function showOptionMenu(button) {

	// 1. Get the song id from button
	let songId = $(button).prevAll(".songId").val();

	// return the width property
	let menu = $(".optionMenu");
	let munuWidth = menu.width();

	// 2. Set the song id value to optionMenu input
	menu.find(".songId").val(songId);

	// distance from top of window to top of document
	let scrollTop = $(window).scrollTop();
	// distance from top of document
	let elementOffset = $(button).offset().top;

	let top = elementOffset - scrollTop;
	let left = $(button).position().left;

	menu.css({
		"top": top + "px",
		"left": left - munuWidth + "px",
		"display": "inline"
	});
}

function hideOptionMenu() {
	let menu = $(".optionMenu");
	if(menu.css("display") != "none") {
		menu.css("display", "none"); 
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
