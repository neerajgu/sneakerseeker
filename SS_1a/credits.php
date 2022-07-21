<?php session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=stylesheet href=styles/store.css>
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

    <title>SneakerSeeker | Home</title>
</head>

<body>
    <ul class=nav-bar>
        <li class=nav-home><a href=store.php>Home</a></li>
        <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>
        <li><a href=cart.php>Cart</a></li>
        <li><a aria-current=page href='credits.php'>Credits</a></li>
    </ul>
    <div class='creditBox'>
      <p>Login Background Image:</p>
      <a href='https://wallpaperaccess.com/air-jordan-11'>Wallpaper Access</a>
    </div>
    <div class='creditBox'>
      <p>Shoes:</p>
      <a href='https://images.stockx.com'>StockX Images</a>
    </div>
</body>

</html>
