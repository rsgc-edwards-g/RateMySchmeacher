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
    
    $head_query = "SELECT course_id, section_id FROM section WHERE syst_id = '" . $_POST['course'] . "';";
    $head_result = mysqli_fetch_assoc(mysqli_query($connection, $head_query));
    $class_head = "" . $head_result['course_id'] . "-" . $head_result['section_id'] . "";
    
    // Get the student ids of all the students in this particular class
    $query = "SELECT students_id FROM students_has_courses WHERE section_syst_id = '" . $_POST['course'] . "';";
    $result = mysqli_query($connection, $query);
    
    // Iterate over the result set
    $output = "<table>" . "<tr>" . "<td>"."Students"."</td>" . "<td>"."Drop Student"."</td>"."</tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $name_query = "SELECT first_name, last_name FROM students WHERE id = '" . $row['students_id'] . "';";
        $name = mysqli_fetch_assoc(mysqli_query($connection, $name_query));
        $output .= "<tr>";
        $output .= "<td>" . $name['first_name'] . " " . $name['last_name'] . "</td>";
        $output .= "<td>";
        $output .= "<form action='drop.php' method='post'>
        <input type='submit' value='Drop Student'> 
        <input type='hidden' name='student' value='" . $row['students_id'] . "'>
        <input type='hidden' name='course' value='" . $_POST['course'] . "'>
        </form>";
        $output .= "</td>";
        $output .= "</tr>";
    }
    $output .= "</table>";
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
    
    <h1><?php echo $class_head; ?> Student List</h1>

    <main>
        <p><a></a></p>
        
        <?php echo $output ?><br>
        <form action='add.php' method='post'>
            <input type="hidden" name= "course" value="<?php echo $_POST['course']?>">
            <input type="submit" value="Add a Student">
    </main>
  
</body>
</html>