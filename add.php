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
    
    $head_query = "SELECT course_id, section_id FROM section WHERE syst_id = '" . $_SESSION['course'] . "';";
    $head_result = mysqli_fetch_assoc(mysqli_query($connection, $head_query));
    $class_head = "" . $head_result['course_id'] . "-" . $head_result['section_id'] . "";
    
    
    $school_query = "SELECT id, first_name, last_name, grade FROM students WHERE id NOT IN (SELECT students_id FROM students_has_courses WHERE section_syst_id = " . $_SESSION['course'] . ");";
    $school_result = mysqli_query($connection, $school_query);
    while ($school_row = mysqli_fetch_assoc($school_result)){
        $output .= "<tr><td>";
        $output .= $school_row['first_name'] . " " . $school_row['last_name'];
        $output .= "</td><td>";
        $output .= $school_row['grade'];
        $output .= "</td><td>";
        $output .= "<input type = 'checkbox' name = 'students[]' value = '" . $school_row['id'] . "'>";
        $output .= "</td></tr>";
    }
    
    if(isset($_POST['submit']))  {
        $students[] = $_POST['students'];
        for ($i = 0; $i < count($students); $i++) {
            $enter_query = "INSERT INTO students_has_courses (students_id, section_syst_id) VALUES ('" . $students[i] . "', " . $_SESSION['course'] . ");";
            $enter_result = mysqli_query($connection, $enter_query);
            if (! $row = mysqli_fetch_assoc($enter_result)){
                $message['general'] = "We could not add all of the students to your class. Please try again.";
            }
        }
        
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'addDropStudent.php';
        header("Location: http://$host$uri/$extra");
        exit;
    
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
    <h1><?php echo $class_head; ?> Student Add Page</h1>

    <main>
        
        <form action="add.php" method="post">
            <table>
                <tr>
                    <td>Student</td>
                    <td>Grade</td>
                    <td>Add Student</td>
                </tr>
                <?php echo $output ?>
            </table>
            
            <input type="submit" name="submit" value="Add this student"><br/><br/>
            <a href="addDropStudent.php"><button type="button">Cancel</button></a><br/><br/>
            <?php echo $message['general']; ?>
        </form>

    </main>
  
</body>
</html>