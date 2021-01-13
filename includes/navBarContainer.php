<div id="nowBarContainer">

    <div class="navBar">

        <span class="logo" onclick="openPage('index.php')">
            <img src="assets/images/logo/logo-white.png" alt="Cloud Music Home Page">
            <span id="logoName">CLOUD MUSIC</span>
        </span>

        <div class="group">
            <div class="navItem">
                <span onclick="openPage('home.php')"class="navItemLink"  id="homeLink">
                    <img id="homeImage" src="assets/images/icons/home-black.png" alt="Home"><span id="homeName">Home</span>
                </span>
            </div>
            <div class="navItem">
                <span onclick="openPage('search.php')" class="navItemLink" id="searchLink">
                    <img id="searchImage" src="assets/images/icons/search-black.png" alt="Home"><span id="searchName">Search</span>
                </span>
            </div>
            <div class="navItem">
                <span onclick="openPage('yourLibrary.php')" class="navItemLink" id="libraryLink">
                    <img id="libraryImage" src="assets/images/icons/library-black.png" alt="Home"><span id="libraryName">Your Library</span>
                </span>
            </div>
            <div class="navItem">
                <div id="loveSongText">LOVE SONGS</div>
                <span onclick="openPage('loveSong.php')" class="navItemLink" id="loveSongLink">
                    <img id="longSongImage" src="assets/images/icons/loveSong-grey.png" alt="Love Song"><span id="longSongName">Liked Songs</span>
                </span>
                <div id="line"></div>
            </div>
            <div class="navItem playListContainer scroller">

                <?php

                    try {
                        $usernameSave = $userLoggedIn;

                        $sql = "SELECT * FROM PlaylistsOwner WHERE owner = :owner";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([
                            ':owner' => $usernameSave
                        ]);
    
                        while($row = $stmt->fetch()) {
    
                            $playlist = new Playlist($pdo, $row);
    
                            echo "<div class='playListItem' onclick='openPage(\"playlist.php?id={$playlist->getId()}\")'>{$playlist->getName()}</div>";
                        }
                    } catch (Exception $ex) {
                        echo("Internal error, please contact support");
                        error_log("Genre.php, SQL error=" . $ex->getMessage());
                    }
                    
                ?>

            </div>
        </div> <!-- group end -->


    </div> <!-- navBar end -->

</div> <!-- nowBarContainer end -->