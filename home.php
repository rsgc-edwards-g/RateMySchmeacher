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
    

    $query = "SELECT section_syst_id FROM students_has_courses WHERE students_id = ('" . $_SESSION['id'] . "');";
    $result = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($result)){
        $output .= "<tr>";
        $new_query = "SELECT course_id, teacher_id FROM section WHERE syst_id = ('" . $row['section_syst_id'] . "');";
        $info_result = mysqli_query($connection, $new_query);
        $info = mysqli_fetch_assoc($info_result);
        $output .= "<td>";
        $output .= $info['course_id'];
        $output .= "</td>";
        $teacher_query = "SELECT first_name, last_name FROM teacher WHERE id = '" . $info['teacher_id'] . "';";
        $teacher_result = mysqli_query($connection, $teacher_query);
        $teacher_names = mysqli_fetch_assoc($teacher_result);
        $output .= "<td>";
        //print_r($teacher_names);
        //die();
        $output .= "" . $teacher_names['first_name'] . " " . $teacher_names['last_name'] . "";
        $output .= "</td>";
        $output .= "<td>
        <form action='rating.php'>
        Rate <input type='submit' value='Rate'> 
        <input type='hidden' name='course' value='" . $info['course_id'] . "'>
        </form></td>";
        $output .= "</tr>";
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
        <?php include 'header.php'; ?>
    </header>

    
        <h2>Your Classes</h2>
        <table>
            <tr>
                <td>Course</td>
                <td>Teacher</td>
                <td>Rate a Class</td>
            </tr>
            <?php echo $output ?>
        </table>
            
    <main>

    </main>
  
</body>
</html>