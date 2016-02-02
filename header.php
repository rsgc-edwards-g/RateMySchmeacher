<?php

    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Header</title>

</head>

<body>
    <header>
    </header>

    <main>
        <button type="button"><a href="./logout.php">Log Out</a></button>
        <button type="button"><a href="$_SERVER['HTTP_REFERRER']">Go Back</a></button>
    </main>
  
</body>
</html>
