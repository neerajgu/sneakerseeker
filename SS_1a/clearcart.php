<?php
session_start();
require_once"config.php";
//clearing cart items where the user is the logged in user's id
try {
    $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
    $sth=$dbh->prepare("DELETE FROM cart WHERE user_id=:givenUID");
    $sth->bindValue("givenUID", $_SESSION["id"]);
    $check = $sth->execute();
    if($check == 1){
        header("Location: cart.php");
    } else {
        echo "unknown user, bad data.";
    }
}
catch (PDOException $e) {
    echo "<p>Error: {$e->getMessage()}</p>";
}
