<?php
    // Check whether session created (is user logged in?)
    // If not, re-direct to main index page.
    session_start();
    if(!isset($_SESSION['username']))
    {
        // Not logged in, re-direct to the login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }

    // Connect to database
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    

?>

<!doctype html>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Shmee</title>

  <link rel="stylesheet" href="./CSS/Stylin.css?v=1.0">
  
</head>

<body>

    
    <header>
        <?php include 'header.php'; ?>
    </header>

    
        <h2>Your Classes</h2>
        <table>
            <tr>
                <td>Course</td>
                <td>Teacher</td>
                <td>Rate a Class</td>
            </tr>
            <tr>
                <td>She doesnt even go here</td>
                <td>Michael Ruscitti</td>
                <td><a href="./rating.php">Rate</a></td>
            </tr>
        </table>
            
    <main>

    </main>
  
</body>
</html>