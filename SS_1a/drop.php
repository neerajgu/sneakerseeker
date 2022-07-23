<?php
session_start();
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
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <?php
    require_once "config.php";
    try {
        $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);

        //$dbh->exec("DROP TABLE users");
        $dbh->exec("DROP TABLE cart");
        $dbh->exec("DROP TABLE shoes");
    } catch (PDOException $e) {
        echo "<p>Error: {$e->getMessage()}</p>";
    }
    ?>
</body>

</html>