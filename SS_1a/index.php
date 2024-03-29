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
  <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
  <script defer src="javascript/showpswd.js"></script>
</head>

<body>
  <?php
  //checking visits
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
      //validating form
      //i decided not to add any of the length validation because that ended up changing several times. (e- the admin account has a username of 5 chars)
      if ($_SESSION['visits'] > 0 && $_POST['username'] != "" && $_POST['password'] != "") {
        try {
          $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
          $sth = $dbh->prepare("SELECT password, id FROM users WHERE username=:username");
          $sth->bindValue(":username", htmlspecialchars($_POST['username']));
          $sth->execute();
          $pwd = $sth->fetch();
          //making sure the password matches.
          if (password_verify($_POST['password'], $pwd['password'])) {
            $_SESSION['username'] = htmlspecialchars($_POST['username']);
            $_SESSION['id'] = $pwd['id'];
            header("Location: store.php");
          } else {
            //its possible the user entered the correct password but accidentally entered someone else's username... so its incorrect pwd or usr.
            echo "<p>Incorrect password or username.</p>";
          }
        } catch (PDOException $e) {
          echo "<p>Error: {$e->getMessage()}</p>";
        }
      }
      ?>
      <input id="username" type="text" name="username" placeholder="Username" required><br>
      <input class='password' id="password" type="password" name="password" placeholder="Password" required>
      <button type="submit">Lets Go!</button>
      <p>No Account? <a href='signup/index.php'>Sign Up!</a></p>
    </form>
  </div>
</body>

</html>
