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
        //create comic table
        $query = file_get_contents('database/store.sql');
        $dbh->exec($query);
        echo "<p>Successfully installed databases</p>";
        $pass = password_hash("password", PASSWORD_DEFAULT);

        // remove existing admin
        $dbh->exec("DELETE FROM `users` WHERE admin=1");
        $admin = $dbh->prepare("INSERT INTO `users` (`id`, `username`, `password`, `admin`) VALUES (1, 'admin', :pass, true)");
        $admin->bindValue(":pass", $pass);
        $admin->execute();

        echo "<p>Created admin account   username: admin password: password</p>";
    } catch (PDOException $e) {
        echo "<p>Error: {$e->getMessage()}</p>";
    }
    ?>
</body>

</html>
