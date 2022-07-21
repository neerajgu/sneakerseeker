<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
include_once "config.php";
$db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

$cart = $db->prepare("SELECT showImg, shoeName, colorWay, shoes.id FROM cart
 JOIN shoes ON shoes.id=cart.shoe_id
 WHERE :currUser=cart.user_id");
$cart->bindValue(":currUser", $_SESSION["id"]);
$cart->execute();
$cart = $cart->fetchAll();

//add to cart
if (isset($_GET["cart"])) {
    $insert = $db->prepare("INSERT INTO cart (shoe_id, user_id) VALUES (:givenShoe, :givenUID)");
    $insert->bindValue(":givenShoe", $_GET["cart"]);
    $insert->bindValue("givenUID", $_SESSION["id"]);

    $insert->execute();

    header("Location: store.php?id={$_GET["cart"]}?success=1");
}

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
    <link rel=stylesheet href=styles/cart.css>
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="store.js"></script>

    <title>SneakerSeeker | Cart</title>
</head>

<body>
    <ul class=nav-bar>
        <li class=nav-home><a href=store.php>Home</a></li>
        <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>
        <li aria-current=page><a href=cart.php>Cart</a></li>
        <li><a href='credits.php'>Credits</a></li>
    </ul>

    <div class=storeSection>
        <div class=storeLabel>
            <h2>Your Cart - <?php echo count($cart); ?> items</h2>
        </div>
        <div class=storeScrollMenu>
            <?php

            foreach ($cart as $shoe) {
                displayContainer($shoe);
            }
            ?>
        </div>
    </div>

</body>

</html>
