<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
        <style>
            table, tr, td {
                border: 1px solid black;
                text-align: center;
                padding: 5px;
            }
        </style>
    </head>
    <body>


        <?php
        $namePlyr = false;
        $pswdPlyr = false;
        //Form $_SESSION['playerID'] = $_POST['trainer'];
        require_once("config.php");
        if (!isset($_SESSION['playerID'])) {
            if ($_POST['trainer'] == NULL) {
                header("Location: signin.php");
            } else {
                $namePlyr = true;
            }
        }
        try {
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $sth = $dbh->prepare("SELECT * FROM player");
            $sth->execute();
            $playerArray = $sth->fetchAll();
            if ($namePlyr) {
                foreach ($playerArray as $player) {
                    if (password_verify($_POST['password'], $player['password_hash'])) {
                        $pswdPlyr = true;
                        $_SESSION['playerID'] = $_POST['trainer'];
                    } else {
                        header("Location: signin.php");
                    }
                }
            }
            $sth2 = $dbh->prepare("SELECT * FROM ownership JOIN player ON ownership.player_id = player.id JOIN parkamon ON ownership.parkamon_id = parkamon.id WHERE player_id=:playerID ORDER BY player.name, parkamon.breed, ownership.nickname");
            $sth2->bindValue(":playerID", $_SESSION['playerID']);
            $sth2->execute();
            $ownershipArray = $sth2->fetchAll();
            $sth3 = $dbh->prepare("SELECT name FROM player WHERE id=:id");
            $sth3->bindValue(":id", $_SESSION['playerID']);
            $sth3->execute();
            $playerName = $sth3->fetch();
        }
        catch (PDOException $e) {
            echo "<p>Error: {$e->getMessage()}</p>";
        }
        echo "<b>Hello, {$playerName['name']}!</b>";

        echo "<form action='catch.php' method='post'><input type='submit' value='catch a parkamon'></form>";
        //RENAME
        echo "<form action='rename.php' method='post'>";
        echo "rename parkamon:<br>";
        echo "<select required name='ownedPark'>";
        foreach ($ownershipArray as $owned) {
            echo "<option value='{$owned[0]}'>{$owned['breed']}</option>";
        }
        echo "</select>";
        echo "<input required name='renamePark' maxlength='9' type='text' placeholder='nickname'>";
        echo "<input type='submit' value='rename'>";
        echo "</form>";
        //RELEASE
        echo "<form action='release.php' method='post'>";
        echo "release parkamon:<br>";
        echo "<select required name='releasePark'>";
        foreach ($ownershipArray as $owned) {
            echo "<option value='{$owned[0]}'>{$owned['breed']}</option>";
        }
        echo "</select>";
        echo "<input type='submit' value='release'>";
        echo "</form>";

        echo "<TABLE>";
        echo "<tr><th scope='column'>Owner</th><th scope='column'>Breed</th><th scope='column'>Location</th><th scope='column'>Nickname</th></tr>";
        foreach ($ownershipArray as $owner) {
            echo "<tr><td>{$owner['name']}</td><td>{$owner['breed']}</td><td>{$owner['location']}</td><td>{$owner['nickname']}</td></tr>";
        }
        echo "</TABLE>";
        echo "<p>Tired of playing? <a href='signout.php'>Log Out!</a></p>";
        ?>
    </body>
</html>
