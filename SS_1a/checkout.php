<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
require_once"config.php";
$displayForm=true;
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
   </head>
   <body>
      <ul class=nav-bar>
         <li aria-current=page class=nav-home><a href=store.php>Home</a></li>
         <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>
         <li><a href=cart.php>Cart <strong><?php echo $cartItems?></strong></a></li>
         <li><a href='credits.php'>Credits</a></li>
         <?php
         try{
            $db = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
            $admin = $db->prepare("SELECT admin FROM users WHERE id=:currID");
            $admin->bindValue(":currID", $_SESSION["id"]);
            $admin->execute();

            $admin = $admin->fetchAll();

            if(!empty($admin) && $admin[0]["admin"] == "1") {
               echo "<li><a href=admin.php><strong>AdminPanel<strong></a></li>";
            }}
            catch (PDOException $e) {
               echo "<p>Error: {$e->getMessage()}</p>";
            }
            ?>
         </ul>
      <?php
      try {
         $dbh = new PDO(DB_DSN, DB_USER, DB_PASSWORD);
         if(isset($_POST['password'])){
            $sth=$dbh->prepare("SELECT * FROM users WHERE id=:loginId");
            $login = $_SESSION['id'];
            $sth->bindValue(":loginId", $login);
            $sth->execute();
            $password =$sth->fetch();

            $sth=$dbh->prepare("DELETE FROM cart WHERE user_id=:givenUID");
            $sth->bindValue("givenUID", $_SESSION["id"]);
            $check = $sth->execute();

            if(password_verify(htmlspecialchars($_POST['password']),$password['password']) == true){
               if($check == 1){
                  $displayForm = false;
                  echo"</br>";
                  echo"<h2>Order Placed, thank you for shopping Sneaker Seaker</h2>";
               }
            }
            else{
               echo"Password is Invalid";
            }
         }
         $cart = $dbh->prepare("SELECT * FROM cart WHERE :currUser=cart.user_id");
         $cart->bindValue(":currUser", $_SESSION["id"]);
         $cart->execute();
         $cart = $cart->fetchAll();

         $cartItems = $dbh->prepare("SELECT SUM(shoeCost) FROM cart JOIN shoes ON shoes.id=cart.shoe_id WHERE :currUser=cart.user_id");
         $cartItems->bindValue(":currUser", $_SESSION["id"]);
         $cartItems->execute();
         $cartCost = $cartItems->fetch();

      }
      catch (PDOException $e) {
          echo "<p>Error: {$e->getMessage()}</p>";
      }
       ?>
       <?php if($displayForm){?>
       <p></p>
       <div class="checkOut">
          <div class="user">
             <?php echo htmlspecialchars($_SESSION['username']) ."&#39;s Checkout</br>"; ?>
          </div>
         <div class="totalItems">
            Total Items: <?php echo count($cart);?>
         </div>
         <div class="total">
            Total Cost: <?php echo $cartCost[0];?>
         </div>
         <form class="password" action="checkout.php" method="post">
            <input type="text" name="password" placeholder="Enter Password To Confirm" required>
            <input type="submit" name="Checkout">
         </form>
      <?php } ?>
       </div>
   </body>
</html>
