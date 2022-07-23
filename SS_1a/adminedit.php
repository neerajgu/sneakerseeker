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

if (empty($admin) || $admin[0]["admin"] != "1") {
    //not admin
    header("Location: store.php");
}

if (isset($_POST["id"])) {
    //handle posts for editing
    $edit = $db->prepare(
        "UPDATE shoes SET
    shoeName=:givenShoeName, 
    shoeBrand=:givenShoeBrand, 
    colorWay=:givenColorWay, 
    shoeCost=:givenShoeCost, 
    showImg=:givenShowImg
    where id=:givenID"
    );

    $edit->bindValue(":givenShoeName", $_POST["shoeName"]);
    $edit->bindValue(":givenShoeBrand", $_POST["shoeBrand"]);
    $edit->bindValue(":givenColorWay", $_POST["colorWay"]);
    $edit->bindValue(":givenShoeCost", $_POST["shoeCost"]);
    $edit->bindValue(":givenShowImg", $_POST["showImg"]);
    $edit->bindValue(":givenID", $_POST["id"]);

    $edit->execute();;
}
