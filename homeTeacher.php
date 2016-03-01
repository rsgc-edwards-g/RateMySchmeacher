<?php
    // Check whether session created (is user logged in?)
    // If not, re-direct to main index page.
    session_start();
    //print_r($_SESSION);
    //die();
    if(!isset($_SESSION['username']))
    {
        // Not logged in, re-direct to the login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
    }
    // Show list of courses on home page 
    // Connect to database
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    /*
    // And now perform simple query – make sure it's working
    $query = "SELECT id, first_name, last_name FROM teacher;";
    $result = mysqli_query($connection, $query);
    
    // Iterate over the result set
    $output = "<ul>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<li>";
        $output .= "<a href=\"./course/?cid=" . urlencode($row['id']) . "\">" . $row['first_name'] . ": " . $row['last_name'] . "</a>";
        $output .= "</li>";
    }
    $output .= "</ul>";*/
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
        <?php include 'headerTeacher.php'; ?>
    </header>
    <h1><?php echo $_SESSION['username']; ?>'s teacher page</h1>
    <nav>
        <ul>
            <li><a href="./logout.php">logout</a></li>
            <li>Home</li>
            <li><a href="./createSection.php">Create a Course Section</a></li>
        </ul>
    </nav>

    <main>
        <p><a></a></p>

        <?php echo $output ?>

    </main>
  
</body>
</html>