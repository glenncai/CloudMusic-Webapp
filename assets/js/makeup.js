// For now playing bar
const playButtonChange = document.getElementById("playChange");
const pauseChange = document.getElementById("pauseChange");
const shuffleChange = document.getElementById("shuffleChange");
const shuffleChangeActive = document.getElementById("shuffleChangeActive");
const previousChange = document.getElementById("previousChange");
const nextChange = document.getElementById("nextChange");
const repeatChange = document.getElementById("repeatChange");
const repeatChangeActive = document.getElementById("repeatChangeActive");
const unlike = document.getElementById("unlike");
const volumeChange = document.getElementById("volumeChange");
const volumeChangeActive = document.getElementById("volumeChangeActive");

// For nav bar
const homeLink = document.getElementById("homeLink");
const searchLink = document.getElementById("searchLink");
const libraryLink = document.getElementById("libraryLink");
const profileLink = document.getElementById("profileLink");
const loveSongLink = document.getElementById("loveSongLink");
const homeImage = document.getElementById("homeImage");
const searchImage = document.getElementById("searchImage");
const libraryImage = document.getElementById("libraryImage");
const profileImage = document.getElementById("profileImage");
const longSongImage = document.getElementById("longSongImage");
const homeName = document.getElementById("homeName");
const searchName = document.getElementById("searchName");
const libraryName = document.getElementById("libraryName");
const profileName = document.getElementById("profileName");
const longSongName = document.getElementById("longSongName");
const playListItem = document.getElementsByClassName("playListItem");   


// When mouse hover, the icon will change to white color
playButtonChange.addEventListener("mouseover", mouseOver = () => {
    playButtonChange.src = "assets/images/icons/play-white.png";
});

playButtonChange.addEventListener("mouseout", mouseOut = () => {
    playButtonChange.src = "assets/images/icons/play.png";
});

pauseChange.addEventListener("mouseover", mouseOver = () => {
    pauseChange.src = "assets/images/icons/pause-white.png";
});

pauseChange.addEventListener("mouseout", mouseOut = () => {
    pauseChange.src = "assets/images/icons/pause.png";
});

shuffleChange.addEventListener("mouseover", mouseOver = () => {
    shuffleChange.src = "assets/images/icons/shuffle-white.png";
});

shuffleChange.addEventListener("mouseout", mouseOut = () => {
    shuffleChange.src = "assets/images/icons/shuffle.png";
});

previousChange.addEventListener("mouseover", mouseOver = () => {
    previousChange.src = "assets/images/icons/previous-white.png";
});

previousChange.addEventListener("mouseout", mouseOut = () => {
    previousChange.src = "assets/images/icons/previous.png";
});

nextChange.addEventListener("mouseover", mouseOver = () => {
    nextChange.src = "assets/images/icons/next-white.png";
});

nextChange.addEventListener("mouseout", mouseOut = () => {
    nextChange.src = "assets/images/icons/next.png";
});

repeatChange.addEventListener("mouseover", mouseOver = () => {
    repeatChange.src = "assets/images/icons/repeat-white.png";

});

repeatChange.addEventListener("mouseout", mouseOut = () => {
    repeatChange.src = "assets/images/icons/repeat.png";
});

volumeChange.addEventListener("mouseover", mouseOver = () => {
    volumeChange.src = "assets/images/icons/volume-white.png";
});

volumeChange.addEventListener("mouseout", mouseOut = () => {
    volumeChange.src = "assets/images/icons/volume.png";
});

volumeChangeActive.addEventListener("mouseover", mouseOver = () => {
    volumeChangeActive.src = "assets/images/icons/volume-mute-white.png";
});

volumeChangeActive.addEventListener("mouseout", mouseOut = () => {
    volumeChangeActive.src = "assets/images/icons/volume-mute-white.png";
});


// When user click, button will be green. Click again, 
// the heart will be original.
unlike.addEventListener("click", mouseOver = () => {
    // Determine if the id:unlike is exist.
    if(document.getElementById("unlike")) {
        unlike.id = "like";
    } else {
        unlike.id = "unlike";
    }
});

// For nav bar animation, mouseover and mouseout
homeLink.addEventListener("mouseover", mouseOver = () => {
    homeLink.classList.add("activeLinkHome");
    homeImage.src = "assets/images/icons/home-white.png"
    homeName.style.color = "#fff";
});

homeLink.addEventListener("mouseout", mouseOut = () => {
    homeLink.classList.remove("activeLinkHome");
    homeImage.src = "assets/images/icons/home-black.png"
    homeName.style.color = "#a0a0a0";
});

searchLink.addEventListener("mouseover", mouseOver = () => {
    searchLink.classList.add("activeLinkSearch");
    searchImage.src = "assets/images/icons/search-white.png"
    searchName.style.color = "#fff";
});

searchLink.addEventListener("mouseout", mouseOut = () => {
    searchLink.classList.remove("activeLinkSearch");
    searchImage.src = "assets/images/icons/search-black.png"
    searchName.style.color = "#a0a0a0";
});

libraryLink.addEventListener("mouseover", mouseOver = () => {
    libraryLink.classList.add("activeLinkLibrary");
    libraryImage.src = "assets/images/icons/library-white.png"
    libraryName.style.color = "#fff";
});

libraryLink.addEventListener("mouseout", mouseOut = () => {
    libraryLink.classList.remove("activeLinkLibrary");
    libraryImage.src = "assets/images/icons/library-black.png"
    libraryName.style.color = "#a0a0a0";
});

profileLink.addEventListener("mouseover", mouseOver = () => {
    profileLink.classList.add("activeLinkProfile");
    profileImage.src = "assets/images/icons/contact-white.png"
    profileName.style.color = "#fff";
});

profileLink.addEventListener("mouseout", mouseOut = () => {
    profileLink.classList.remove("activeLinkProfile");
    profileImage.src = "assets/images/icons/contact-grey.png"
    profileName.style.color = "#a0a0a0";
});

loveSongLink.addEventListener("mouseover", mouseOver = () => {
    loveSongLink.classList.add("activeLinkLongSong");
    longSongImage.src = "assets/images/icons/loveSong-red.png"
    longSongName.style.color = "#fff";
});

loveSongLink.addEventListener("mouseout", mouseOut = () => {
    loveSongLink.classList.remove("activeLinkLongSong");
    longSongImage.src = "assets/images/icons/loveSong-grey.png"
    longSongName.style.color = "#a0a0a0";
});

// for playlist mouseover and mouseout
// for className, we should use for loop
// because it is not unique
for(let i = 0; i < playListItem.length; i++) {
    playListItem[i].addEventListener("mouseover", changePlaylistItemColorToWhite = () => {
        playListItem[i].style.color = "#fff";
    });
}

for(let i = 0; i < playListItem.length; i++) {
    playListItem[i].addEventListener("mouseout", changePlaylistItemColorToGrey = () => {
        playListItem[i].style.color = "#a0a0a0";
    });
}

// For nav bar, click event
homeLink.addEventListener("click", remainPage = () => {
    homeLink.classList.add("remainHomePage");
    searchLink.classList.remove("remainSearchPage");
    libraryLink.classList.remove("remainLibraryPage");
    profileLink.classList.remove("remainProfilePage");
    loveSongLink.classList.remove("remainLongSongPage");
});

searchLink.addEventListener("click", remainPage = () => {
    homeLink.classList.remove("remainHomePage");
    searchLink.classList.add("remainSearchPage");
    libraryLink.classList.remove("remainLibraryPage");
    profileLink.classList.remove("remainProfilePage");
    loveSongLink.classList.remove("remainLongSongPage");
});

libraryLink.addEventListener("click", remainPage = () => {
    homeLink.classList.remove("remainHomePage");
    searchLink.classList.remove("remainSearchPage");
    libraryLink.classList.add("remainLibraryPage");
    profileLink.classList.remove("remainProfilePage");
    loveSongLink.classList.remove("remainLongSongPage");
});

profileLink.addEventListener("click", remainPage = () => {
    homeLink.classList.remove("remainHomePage");
    searchLink.classList.remove("remainSearchPage");
    libraryLink.classList.remove("remainLibraryPage");
    profileLink.classList.add("remainProfilePage");
    loveSongLink.classList.remove("remainLongSongPage");
});

loveSongLink.addEventListener("click", remainPage = () => {
    homeLink.classList.remove("remainHomePage");
    searchLink.classList.remove("remainSearchPage");
    libraryLink.classList.remove("remainLibraryPage");
    profileLink.classList.remove("remainProfilePage");
    loveSongLink.classList.add("remainLongSongPage");
});











