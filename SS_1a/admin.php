<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
include_once "config.php";
$db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

$admin = $db->prepare("SELECT admin FROM users WHERE id=:currID");
$admin->bindValue(":currID", $_SESSION["id"]);
$admin->execute();

$admin = $admin->fetchAll();

if(empty($admin) || $admin[0]["admin"] != "1") {
    //not admin
    header("Location: index.php");
}

$cartItems = $db->prepare("SELECT showImg, shoeName, colorWay, shoeCost, shoes.id FROM cart
 JOIN shoes ON shoes.id=cart.shoe_id
 WHERE :currUser=cart.user_id");
$cartItems->bindValue(":currUser", $_SESSION["id"]);
$cartItems->execute();

$cartItems = count($cartItems->fetchAll());
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>SneakerSeeker | AdminPanel</title>
        <link rel=stylesheet href=styles/admin.css>
        <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
    </head>
    <body>
        <ul class=nav-bar>
            <li class=nav-home><a href=store.php>Home</a></li>
            <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>
            <li><a href=cart.php>Cart <strong><?php echo $cartItems?></strong></a></li>
            <li><a href='credits.php'>Credits</a></li>
            <?php
            if(!empty($admin) && $admin[0]["admin"] == "1") {
                echo "<li aria-current=page><a href=admin.php><strong>AdminPanel<strong></a></li>";
            }
            ?>
        </ul>

        <form action=
    </body>
</html>
