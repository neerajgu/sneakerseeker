<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

include_once "config.php";
$db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

$verifyID = $db->prepare("SELECT id FROM shoes WHERE id=:givenID");
$verifyID->bindValue(":givenID", $_GET["id"]);
$verifyID->execute();

//if user entered invalid shoeid, kick them back to default store page
if (empty($verifyID->fetchAll()) && isset($_GET["id"])) {
    header("Location: store.php");
}

$distinctBrands = $db->prepare("SELECT DISTINCT shoeBrand FROM shoes");
$distinctBrands->execute();
$distinctBrands = $distinctBrands->fetchAll();

$shoesByBrand = [];

foreach ($distinctBrands as $brand) {
    // grab all of a brand's shoes
    $shoes = $db->prepare("SELECT id, showImg, shoeName, shoeBrand, colorWay FROM shoes WHERE shoeBrand=:givenBrand");
    $shoes->bindValue(":givenBrand", $brand["shoeBrand"]);
    $shoes->execute();
    $shoes = $shoes->fetchAll();
    $shoesByBrand[$brand["shoeBrand"]] = $shoes;
}

/*
$shoes = $db->prepare("SELECT id, showImg, shoeName FROM shoes ORDER BY shoeBrand");
$shoes->execute();
$shoes = $shoes->fetchAll();
*/

function displayContainer(array $item)
{
    echo
    "
    <a href=store.php?id={$item["id"]} title=\"{$item["shoeName"]} | {$item["colorWay"]}\">
    <div class=store-container>
        <img src=https://images.stockx.com/images/{$item["showImg"]}>
        <div class=container-overlay>
            <p>{$item["shoeName"]}</p>
        </div>
    </div>
    </a>
    ";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href=styles/store.css>
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <title>SneakerSeeker | Home</title>
</head>

<body>
    <ul class=nav-bar>
        <li aria-current=page class=nav-home><a href=store.php>Home</a></li>
        <li><a href=profile.php>Profile</a></li>
        <li><a href=cart.php>Cart</a></li>
    </ul>

    <?php
    if (!isset($_GET["id"])) {
        echo
        "
    <div class=store>
        <div class=store-section>
            <div class=store-label>
                <h2>Featured Brands</h2>
            </div>
            <div class=store-scroll-menu>
                <a>
                    <div class=store-container>
                        <img src=img/nike.png>
                        <div class=container-overlay>
                            <p>Nike</p>
                        </div>
                    </div>
                </a>
                <a>
                    <div class=store-container>
                        <img src=img/puma.jpeg>
                        <div class=container-overlay>
                            <p>Puma</p>
                        </div>
                    </div>
                </a>
                <a>
                    <div class=store-container>
                        <img src=img/adidas.png>
                        <div class=container-overlay>
                            <p>Adidas</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class=store-section>
            <div class=store-label>
                <h2>Catalog</h2>
            </div>";

        foreach ($shoesByBrand as $brand) {
            echo "<div class=store-scroll-menu {$brand[0]["brand"]}>";
            foreach ($brand as $shoe) {
                displayContainer($shoe);
            }
            echo "</div>";
        }

        echo
        "
        </div>
    </div>
    ";
    } else {
        $shoe = $db->prepare("SELECT * FROM shoes WHERE id=:givenID");
        $shoe->bindValue(":givenID", $_GET["id"]);
        $shoe->execute();
        $shoe = $shoe->fetch();

        echo "<img class=shoeImg src=https://images.stockx.com/images/{$shoe["showImg"]}>";
    }
    ?>


</body>

</html>
