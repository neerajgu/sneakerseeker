<?php
session_start();
require_once '../config.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Sign Up</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../styles/loginsignup.css">
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script defer src="../javascript/showpswd.js"></script>
</head>

<body>
  <!DOCTYPE html>
  <html lang="en" dir="ltr">

  <head>
    <meta charset="utf-8">
    <title>SneakerSeeker | Sign Up</title>
  </head>

  <body>
    <?php
    //checking session count
    if (isset($_SESSION['visits'])) {
      $_SESSION['visits']++;
    } else {
      $_SESSION['visits'] = 0;
    }
    ?>
    <div id='formContainer'>
      <img id='logo' src='../img/seeker.png' alt='SneakerSeeker'>
      <form method='post' target='_self'>
        <h1>Sign Up</h1>
        <?php
        //validating form completion
        if ($_SESSION['visits'] > 0 && isset($_POST['username']) && $_POST['username'] != "" && isset($_POST['password']) && $_POST['password'] != "" && isset($_POST['password2']) && $_POST['password2'] != "") {
          //validation inputs
          if (strlen($_POST['username']) <= 12 && $_POST['password'] == $_POST['password2'] && strlen($_POST['password']) >= 8) {
            try {
              $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
              $sth = $dbh->prepare("SELECT password, id FROM users WHERE username=:username");
              $sth->bindValue(":username", htmlspecialchars($_POST['username']));
              $sth->execute();
              $pwd = $sth->fetch();
              //only loggin in if password isnt set (meaning there is no account with this username)
              if (!$pwd) {
                $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
                $sth = $dbh->prepare("INSERT INTO users (`username`, `password`) VALUES (:username, :password)");
                $sth->bindValue(":username", htmlspecialchars($_POST['username']));
                $sth->bindValue(":password", password_hash($_POST['password'], PASSWORD_DEFAULT));
                $execute = $sth->execute();
                if ($execute == 1) {
                  $_SESSION['username'] = htmlspecialchars($_POST['username']);
                  $_SESSION['id'] = $pwd['id'];
                  header("Location: ../store.php");
                }
              } else {
                echo "<p>There is an existing account with this username. Please choose another username.</p>";
              }
            } catch (PDOException $e) {
              echo "<p>Error: {$e->getMessage()}</p>";
            }
          } else {
            //finding and printing other possible errors
            if (strlen($_POST['username']) > 12) {
              echo "<p>A username can be up to twelve characters.</p>";
            } elseif (strlen($_POST['password']) < 8) {
              echo "<p>A password must be at least 8 characters</p>";
            } else {
              echo "<p>Your passwords don't match.</p>";
            }
          }
        }
        ?>
        <input required id="username" type="text" name="username" maxlength="12" placeholder="Username"><br>
        <input class='password' required id="password" type="password" name="password" minlength="8" placeholder="Password"><br>
        <input class='password' required id="password2" type="password" name="password2" minlength="8" placeholder="Confirm Password"><br>
        <button type="submit">Lets Go!</button>
      </form>
    </div>
  </body>

  </html>
</body>

</html>
