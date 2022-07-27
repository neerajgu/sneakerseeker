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

if ($_GET["table"] == "user") {
    if (isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT) && $_GET["process"] == "edit" && filter_var($_POST["userAdmin"], FILTER_VALIDATE_INT) !== false) {
        if ($_SESSION["id"] == $_GET["id"]) {
            echo "you cannot edit the permissions of your own account";
        } else {
            $edit = $db->prepare(
                "UPDATE users SET admin=:bool WHERE id=:givenID"
            );
            $edit->bindValue(":bool", ($_POST["userAdmin"] == "1") ? TRUE : FALSE, PDO::PARAM_BOOL);

            $edit->bindValue(":givenID", $_GET["id"]);

            if ($edit->execute()) {
                header("Location: admin.php");
            } else {
                var_dump(($_POST["userAdmin"] == "1") ? TRUE : FALSE);
                var_dump($_GET["id"]);
                echo "invalid data was passed when editing user";
            }
        }
    } else if (isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT) && $_GET["process"] == "delete") {
        $admin = $db->prepare("SELECT admin from users WHERE id=:givenID");
        $admin->bindValue(":givenID", $_GET["id"]);
        $admin->execute();

        // check if targeted deletion is admin, block if it is
        $admin = $admin->fetch();
        if ($admin["admin"] != "1" && !empty($admin)) {
            $delete = $db->prepare(
                "DELETE FROM users WHERE :givenID=id"
            );
            $delete->bindValue(":givenID", $_GET["id"]);

            if ($delete->execute()) {
                header("Location: admin.php");
            } else {
                echo "invalid data was passed when deleting user";
            }
        } else {
            echo "you cannot delete admin accounts";
        }
    } else {
        echo "invalid request on users";
    }
} else if ($_GET["table"] == "shoe") {
    if (isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT) && $_GET["process"] == "delete") {
        $delete = $db->prepare(
            "DELETE FROM shoes WHERE :givenID=id"
        );
        $delete->bindValue(":givenID", $_GET["id"]);

        if ($delete->execute()) {
            header("Location: admin.php");
        } else {
            echo "invalid data was passed when deleting shoe";
        }
    } else if ($_GET["process"] == "add" && filter_var($_POST["shoeCost"], FILTER_VALIDATE_INT) && !empty($_POST["shoeName"]) && !empty($_POST["shoeBrand"]) && !empty($_POST["colorWay"]) && !empty($_POST["showImg"])) {
        $add = $db->prepare(
            "INSERT INTO shoes (shoeName, shoeBrand, colorWay, shoeCost, showImg) 
        VALUES (:givenShoeName, :givenShoeBrand, :givenColorWay, :givenShoeCost, :givenShowImg)"
        );

        $add->bindValue(":givenShoeName", htmlspecialchars($_POST["shoeName"]));
        $add->bindValue(":givenShoeBrand", htmlspecialchars($_POST["shoeBrand"]));
        $add->bindValue(":givenColorWay", htmlspecialchars($_POST["colorWay"]));
        $add->bindValue(":givenShoeCost", $_POST["shoeCost"]);
        $add->bindValue(":givenShowImg", htmlspecialchars($_POST["showImg"]));

        var_dump($_POST);

        if ($add->execute()) {
            header("Location: admin.php");
        } else {
            echo "invalid data was passed when adding shoe";
        }
    } else if (isset($_GET["id"]) && filter_var($_GET["id"], FILTER_VALIDATE_INT) && $_GET["process"] == "edit" && filter_var($_POST["shoeCost"], FILTER_VALIDATE_INT) && !empty($_POST["shoeName"]) && !empty($_POST["shoeBrand"]) && !empty($_POST["colorWay"]) && !empty($_POST["showImg"])) {
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

        $edit->bindValue(":givenShoeName", htmlspecialchars($_POST["shoeName"]));
        $edit->bindValue(":givenShoeBrand", htmlspecialchars($_POST["shoeBrand"]));
        $edit->bindValue(":givenColorWay", htmlspecialchars($_POST["colorWay"]));
        $edit->bindValue(":givenShoeCost", $_POST["shoeCost"]);
        $edit->bindValue(":givenShowImg", htmlspecialchars($_POST["showImg"]));

        $edit->bindValue(":givenID", $_GET["id"]);

        if ($edit->execute()) {
            header("Location: admin.php");
        } else {
            echo "invalid data was passed when editing shoe";
        }
    } else {
        echo "invalid request on shoes";
    }
} else {
    header("Location: store.php");
}
