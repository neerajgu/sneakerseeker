<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>SneakerSeeker | Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/loginsignup.css">
  </head>
  <body>
    <?php
    if (isset($_SESSION['visits'])) {
      $_SESSION['visits']++;
    } else {
      $_SESSION['visits'] = 0;
    }
    ?>
    <div id='formContainer'>
      <form method='post' target='_self'>
        <h1>Log In</h1>
        <?php
        if ($_SESSION['visits'] > 0 && $_POST['username'] != "" && $_POST['password'] != "") {
          try {
            $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $sth = $dbh->prepare("SELECT password FROM users WHERE username=:username");
            $sth->bindValue(":username", htmlspecialchars($_POST['username']));
            $sth->execute();
            $pwd = $sth->fetch();
            if (password_verify($_POST['password'], $pwd[0])) {
              $_SESSION['username'] = htmlspecialchars($_POST['username']);
              header("Location: store.php");
            } else {
              echo "<p>Incorrect password or username.</p>";
            }
          } catch (PDOException $e) {
              echo "<p>Error: {$e->getMessage()}</p>";
          }
        }
        ?>
        <input id="username" type="text" name="username" maxlength="12" placeholder="Username"><br>
        <input id="password" type="password" name="password" minlength="8" placeholder="Password">
        <button type="submit">Lets Go!</button>
        <p>No Account? <a href='/ngummalam/Project-2/signup'>Sign Up!</a></p>
      </form>
    </div>
  </body>
</html>
