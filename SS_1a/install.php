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
            //https://www.php.net/manual/en/function.file-get-contents.php
            //https://www.php.net/manual/en/pdo.exec
        }
        catch (PDOException $e) {
            echo "<p>Error: {$e->getMessage()}</p>";
        }
        ?> 
    </body>
</html>
