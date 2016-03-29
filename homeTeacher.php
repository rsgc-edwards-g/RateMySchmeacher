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
    
    
    // Get the section system id for each section this teacher teaches
    $query = "SELECT syst_id FROM section WHERE teacher_id = ('" . $_SESSION['id'] . "');";
    $result = mysqli_query($connection, $query);
    
    // Iterate over the result set
     while ($row = mysqli_fetch_assoc($result)){
        $output .= "<tr>";
        $new_query = "SELECT name FROM course WHERE id = ('" . $row['syst_id'] . "');";
        $name_result = mysqli_query($connection, $new_query);
        $name = mysqli_fetch_assoc($name_result);
        $output .= "<td>";
        $output .= $name['name'];
        $output .= "</td>";
        $output .= "<td>";
        // Link to the home page for this particular section
        $output .= "";
        $output .= "</td>";
        $output .= "<td>";
        // Link to the class list page for this particular section
        $output .= "";
        $output .= "</td>";
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
        <?php include 'headerTeacher.php'; ?>
    </header>
    <h1><?php echo $_SESSION['username']; ?>'s teacher page</h1>
    <nav>
        <ul>
            <li><a href="./logout.php">logout</a></li>
        </ul>
    </nav>

    <main>
        <p><a></a></p>
        
        <h2>Your Classes</h2>
        <table>
            <tr>
                <td>Course</td>
                <td>Check Ratings</td>
                <td>Class List</td>
            </tr>
            <?php echo $output ?>
        </table>
        
        <a href="./createSection.php">Create a Course Section</a></li>

    </main>
  
</body>
</html>