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
    // Connect to database
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    $head_query = "SELECT course_id, section_id FROM section WHERE syst_id = '" . $_POST['course'] . "';";
    $head_result = mysqli_fetch_assoc(mysqli_query($connection, $head_query));
    $class_head = "" . $head_result['course_id'] . "-" . $head_result['section_id'] . "";
    
    $student_query = "SELECT first_name, last_name FROM students WHERE id = '" . $_POST['student'] . "';";
    $student_result = mysqli_fetch_assoc(mysqli_query($connection, $student_query));
    $student_head = "" . $student_result['first_name'] . " " . $student_result['last_name'] . "";
    
    if (drop == "Yes"){
        $drop_query = "DELETE FROM students_has_courses WHERE students_id = '" . $_POST['student'] . "' AND section_syst_id = '" . $_POST['course'] . "';";   
    }
    
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
    <h1><?php echo $class_head; ?> Student Drop Page</h1>
    <nav>
        <ul>
            <li><a href="./logout.php">logout</a></li>
        </ul>
    </nav>

    <main>
        <p><a></a></p>
        
        <h2>Are you sure you want to drop <?php echo $student_head; ?> from <?php echo $class_head; ?>?</h2><br><br>
        
        <form action="addDropStudent.php" method="post">
            <input type="radio" name="drop" value="Yes"><br>
            <input type="radio" name="drop" value="No">
            <br>
            <input type="submit" name="submit" value="Confirm">
        

    </main>
  
</body>
</html>