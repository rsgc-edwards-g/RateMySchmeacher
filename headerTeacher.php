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
    
    
    $teacher_id = $_SESSION['id'];
    $query = "SELECT * FROM teacher WHERE id = $teacher_id";
    
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    
    $stored_name = $row['first_name'];
    $stored_username = $row['username'];
?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Header</title>

</head>

<body>
  <header>
    <a href="./logout.php" ><button type="button" id="headerbutton" style="margin-right:20px;">Log Out</button></a>
    <a href="<?= $previous ?>"><button type="button" id="headerbutton" style="margin-right:5px;">Go Back</button></a>
    
    <img src="logodraft1.png" alt="shmee" height="75" width="75">
        
    <p>Hello <?php echo $stored_name ?></p>
    <p><?php echo $stored_username ?>'s Teacher Page</p>
    
    </header>
</body>
</html>