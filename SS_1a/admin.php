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

$cartItems = $db->prepare("SELECT showImg, shoeName, colorWay, shoeCost, shoes.id FROM cart
 JOIN shoes ON shoes.id=cart.shoe_id
 WHERE :currUser=cart.user_id");
$cartItems->bindValue(":currUser", $_SESSION["id"]);
$cartItems->execute();

$cartItems = count($cartItems->fetchAll());
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>SneakerSeeker | AdminPanel</title>
    <link rel=stylesheet href=styles/admin.css>
    <link rel="preconnect" href="https://fonts.googleapis.com/%22%3E">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Roboto+Mono|Roboto+Slab|Roboto:300,400,500,700" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
    <script src="javascript/admin.js"></script>
</head>

<body>
    <ul class=nav-bar>
        <li class=nav-home><a href=store.php>Home</a></li>
        <li><a id='logoutBtn' href='logout.php'><?php echo $_SESSION['username']; ?></a></li>
        <li><a href=cart.php>Cart <strong><?php echo $cartItems ?></strong></a></li>
        <li><a href='credits.php'>Credits</a></li>
        <?php
        if (!empty($admin) && $admin[0]["admin"] == "1") {
            echo "<li aria-current=page><a href=admin.php><strong>AdminPanel<strong></a></li>";
        }
        ?>
    </ul>

    <a class=db href=drop.php>Drop Tables</a> </br>
    <a class=db href=install.php>Install Default Tables</a>

    <h2 class=label>Users</h2>
    <table class=users>
        <thead>
            <tr>
                <th class=id>id</th>
                <th class=username>username</th>
                <th class="admin">admin?</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $users = $db->prepare("SELECT * FROM users");
            $users->execute();
            $users = $users->fetchAll();

            foreach ($users as $user) {
                // further verification on backend
                $delDisabled = ($user["admin"] == 1) ? "disabled title=\"Cannot delete admin accounts\"" : "";
                $editDisabled = ($user["id"] == $_SESSION["id"]) ? "disabled title=\"Cannot edit permissions of your own account\"" : "";

                // i swear forms do not affect the loading time at all 
                echo "
                <form action=adminedit.php?table=user&process=edit&id={$user["id"]} method=post id=editUsers{$user["id"]}></form>
                <tr>
                    <td>{$user["id"]}</td>
                    <td><p >" . htmlspecialchars($user["username"]) . "</p></td>
                    <td>
                        <p class=\"admin{$user["admin"]} long\"></p>
                        <select class=off name=userAdmin form=editUsers{$user["id"]}>
                            <option selected disabled>Select permission level</option>
                            <option value=0>False</option>
                            <option value=1>True</option>
                        </select>
                    </td>
                    
                    <td class=editor>
                        <button class=editButton {$editDisabled}>Edit</button>
                        <a href=adminedit.php?table=user&process=delete&id={$user["id"]}><button class=deleteButton {$delDisabled}>Delete</button></a>

                        <button class=\"off cancelButton\">Cancel</button>

                        <input type=submit value=Submit class=\"off submitButton\" form=editUsers{$user["id"]}></input>
                    </td>
                </tr>
            ";
            }
            ?>
        </tbody>
    </table>

    <h2 class=label>Shoes</h2>
    <button class="createButton">Create Shoe</button>
    <button class="cancelCreateButton off">Cancel</button>

    <form class="off add" action=adminedit.php?table=shoe&process=add method=post required>
        <input type=text placeholder="Shoe Name" name=shoeName></input>
        <input type=text placeholder="Shoe Brand" name=shoeBrand></input>
        <input type=text placeholder="Shoe Color" name=colorWay></input>
        <input type=number placeholder="Shoe Cost" name=shoeCost></input>
        <input type=text placeholder="Image File" name=showImg></input>
        <input type=submit value=Submit></input>
    </form>

    <table class=shoes>
        <thead>
            <tr>
                <th class="id">id</th>
                <th class=shoeName>name</th>
                <th class=shoeBrand>brand</th>
                <th class=colorWay>color</th>
                <th class=shoeCost>price</th>
                <th class=showImg>img</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $shoes = $db->prepare("SELECT * FROM shoes");
            $shoes->execute();
            $shoes = $shoes->fetchAll();

            foreach ($shoes as $shoe) {
                // each db row is echoed and can be edited using hidden forms revealed by js
                // input type hiddens are for sending the type of process to adminedit (edit, delete) and target id
                echo "
                <form action=adminedit.php?table=shoe&process=edit&id={$shoe["id"]} method=post id=editShoes{$shoe["id"]}></form>

                <tr>
                    <td>
                        <p>{$shoe["id"]}</p>
                    </td>
                    <td>
                        <p class=long>" . htmlspecialchars($shoe["shoeName"]) . "</p>
                        <input class=off type=text placeholder=\"{$shoe["shoeName"]}\" value=\"{$shoe["shoeName"]}\" name=shoeName form=editShoes{$shoe["id"]}></input>
                    </td>
                    <td>
                        <p class=long>" . htmlspecialchars($shoe["shoeBrand"]) . "</p>
                        <input class=off type=text placeholder=\"{$shoe["shoeBrand"]}\" value=\"{$shoe["shoeBrand"]}\" name=shoeBrand form=editShoes{$shoe["id"]}></input>
                    </td>
                    <td>
                        <p class=long>" . htmlspecialchars($shoe["colorWay"]) . "</p>
                        <input class=off type=text placeholder=\"{$shoe["colorWay"]}\" value=\"{$shoe["colorWay"]}\" name=colorWay form=editShoes{$shoe["id"]}></input>
                    </td>
                    <td>
                        <p class=long>" . htmlspecialchars($shoe["shoeCost"]) . "</p>
                        <input class=off type=text placeholder=\"{$shoe["shoeCost"]}\" value=\"{$shoe["shoeCost"]}\" name=shoeCost form=editShoes{$shoe["id"]}></input>
                    </td>
                    <td>
                        <p class=long>" . htmlspecialchars($shoe["showImg"]) . "</p>
                        <input class=off type=text placeholder=\"{$shoe["showImg"]}\" value=\"{$shoe["showImg"]}\" name=showImg form=editShoes{$shoe["id"]}></input>
                    </td>
                    <td class=editor>
                        <button class=editButton>Edit</button>
                        <a href=adminedit.php?table=shoe&process=delete&id={$shoe["id"]}><button class=deleteButton>Delete</button></a>

                        <button class=\"off cancelButton\">Cancel</button>

                        <input type=submit value=Submit class=\"off submitButton\" form=editShoes{$shoe["id"]}></input>
                    </td>
                </tr>
            ";
            }
            ?>
        </tbody>
    </table>
</body>

</html>
