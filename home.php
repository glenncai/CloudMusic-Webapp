<?php include "includes/includedFiles.php"; ?>

<h2 class="pageHeadingBig">The Best of 2021</h2>
<p class="pageHeadingSmall">Dive into the best songs of 2021 in every genre</p>

<div class="gridViewContainer">

    <?php
        try {
            $sql = "SELECT * FROM Albums ORDER BY RAND() LIMIT 10";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
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
            error_log("home.php, SQL error=" . $ex->getMessage());
        }
    ?>

</div>