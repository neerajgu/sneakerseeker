<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title></title>
    </head>
    <body>
        <?php
        session_start();
        //the stuff
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        //suddenly, thanos snapped his fingers.
        //the stone on his gauntlet glowed.
        //a faint dust started to circulate in the air...
        //and just like that, the session disappeared.
        session_destroy();
        header("Location: index.php");
        ?>
    </body>
</html>
