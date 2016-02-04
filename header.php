<?php
    
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
      $previous = $_SERVER['HTTP_REFERER'];
    }
?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Header</title>

</head>

<body>
    <!-- Placeholder image -->
    <img src="IMG_1501.JPG" alt="shmee" height="100" width="100" align="right">
    <main>
        <button type="button"><a href="./logout.php">Log Out</a></button>
        <button type="button"><a href="<?= $previous ?>">Go Back</a></button>
    </main>
    <br><br><br><br><br>
  <hr>
</body>
</html>
