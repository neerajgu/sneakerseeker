<?php
session_start();
if (!isset($_SESSION['username'])) {
   header("Location: index.php");
}
require_once "config.php";
$displayForm = true;
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
   <meta charset="utf-8">
   <title>Checkout | SS</title>
   <link rel="stylesheet" href="styles/checkout.css">
   <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
   <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
   <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
   <link href=styles/checkout.css rel=stylesheet>
</head>

<body>
   <!-- Nav Bar -->
   <ul class=nav-bar>
      <li aria-current=page class=nav-home><a href=store.php>Home</a></li>
      <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>  <!-- User Name -->
      <li><a href=cart.php>Cart <strong><?php echo $cartItems ?></strong></a></li> <!-- Cart Items -->
      <li><a href='credits.php'>Credits</a></li> <!-- Credits -->
      <?php
      try {
         // Admin Role
         $db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
         $admin = $db->prepare("SELECT admin FROM users WHERE id=:currID");
         $admin->bindValue(":currID", $_SESSION["id"]);
         $admin->execute();

         $admin = $admin->fetchAll();

         if (!empty($admin) && $admin[0]["admin"] == "1") {
            echo "<li><a href=admin.php><strong>AdminPanel<strong></a></li>";
         }
      } catch (PDOException $e) {
         echo "<p>Error: {$e->getMessage()}</p>";
      }
      ?>
   </ul>
   <?php
   try {
      // Set up PDO
      $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
      // Check if they have entered password to verify login
      if (isset($_POST['password'])) {
         $sth = $dbh->prepare("SELECT * FROM users WHERE id=:loginId");
         $login = $_SESSION['id'];
         $sth->bindValue(":loginId", $login);
         $sth->execute();
         $password = $sth->fetch();
         // Check if password enterd is user Password
         if (password_verify(htmlspecialchars($_POST['password']), $password['password']) == true) {
            $sth = $dbh->prepare("DELETE FROM cart WHERE user_id=:givenUID");
            $sth->bindValue("givenUID", $_SESSION["id"]);
            $check = $sth->execute();
            // If it passes then say thank you
            if ($check == 1) {
               $displayForm = false;
               echo "</br>";
               echo "<h2>get scammed</h2>";
            }
            // Do an error fi exec did not work
            else {
               echo "</br>";
               echo "<h2>There was an error in checking out.</h2>";
            }

         } else {
            // password wrong
            echo "Password is Invalid";
         }
      }
      // Getting cart items to get total item number
      $cart = $dbh->prepare("SELECT * FROM cart WHERE :currUser=cart.user_id");
      $cart->bindValue(":currUser", $_SESSION["id"]);
      $cart->execute();
      $cart = $cart->fetchAll();

      // Cost of cart
      $cartItems = $dbh->prepare("SELECT SUM(shoeCost) FROM cart JOIN shoes ON shoes.id=cart.shoe_id WHERE :currUser=cart.user_id");
      $cartItems->bindValue(":currUser", $_SESSION["id"]);
      $cartItems->execute();
      $cartCost = $cartItems->fetch();
   } catch (PDOException $e) {
      echo "<p>Error: {$e->getMessage()}</p>";
   }
   ?>
   <!-- Just to remove the form after checkout -->
   <?php if ($displayForm) { ?>
      <p></p>
      <div class="checkOut">
         <div class="user">
            <?php echo htmlspecialchars($_SESSION['username']) . "&#39;s Checkout</br>"; ?>
         </div>
         <hr>
         <div class="totalItems">
            <p>Total Items: <?php echo count($cart); ?></p>
         </div>
         <hr>
         <div class="total">
            <p>Total Cost: $<?php echo $cartCost[0]; ?>.00</p>
         </div>
         <hr>
         <form class="password" action="checkout.php" method="post">
            <input type="text" name="password" placeholder="Confirm Password" required>
            <button type="submit">Checkout</button>
         </form>
      <?php } ?> <!-- Closing the if statement -->
      </div>
</body>

</html>
