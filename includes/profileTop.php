<div id="profileContainer">
    <div id="profileContainerItem">
        <div class="previous__next">
            <span id="prevPage"><img src="assets/images/icons/prevPage.png" alt="Next page"></span>
            <span id="nextPage"><img src="assets/images/icons/nextPage.png" alt="Prev page"></span>
        </div>
        <div id="profileInfo">

            <?php

            $sql_user = "SELECT * FROM users WHERE username = :username";
            $stmt_user = $pdo->prepare($sql_user);
            $stmt_user->execute([
                ':username' => $userLoggedIn
            ]);
            $row_user = $stmt_user->fetch();

            ?>

            <div id="personalInfo">
                <span id="personalInfoText"><?php echo $row_user->firstname; ?> <?php echo $row_user->lastname; ?></span>
                <img src="<?php echo $row_user->profilePic; ?>">
            </div>

        </div>
    </div>
</div>