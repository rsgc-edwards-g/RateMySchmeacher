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
    
    if(isset($_POST['submit']))  {
    $provided_first_name = htmlspecialchars(trim($_POST['first_name']));
    $provided_last_name = htmlspecialchars(trim($_POST['last_name']));


    if (strlen($provided_first_name) == 0) {
        $message['first_name'] = "First name is required.";
    }
    if (strlen($provided_last_name) == 0) {
        $message['last_name'] = "Last name is required.";
    }
    
    if(!isset($message)){
        
        // Get the student's id
        $student_query = "SELECT id FROM students WHERE first_name = '" . $provided_first_name . "' AND last_name = '" . $provided_last_name . "';";
        $student_id = mysqli_fetch_assoc(mysqli_query($connection, $student_query));
        
        // Check to see whether the student is registered in the course already
        $check_query = "SELECT * FROM students_has_courses WHERE students_id = " . $student_id . " AND section_syst_id = " . $_POST['course'] . ";";
        $check_result= mysqli_query($connection, $check_query);
        if (! $row = $check_result){
            $add_query = "INSERT INTO students_has_courses (students_id, section_syst_id) VALUES('" . $student_id . "', '" . $_POST['course'] . "');";
            
            if (! mysqli_query($connection, $add_query)) {
                // Show an error message, something unexpected happened (query should succeed)
                $message['general'] = "We could not add " . $provided_first_name . " " . $provided_last_name . " to " . $class_head . " at this time. Please try again later.";
            } 
        }
        
    }
    
    
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
    <nav>
        <ul>
            <li><a href="./logout.php">logout</a></li>
        </ul>
    </nav>

    <main>
        <p><a></a></p>
        
        <h2>Please enter the name of the student you want to add to <?php echo $class_head; ?></h2><br><br>
        
        <form action="addDropStudent.php" method="post">
            Enter the student's first name:<br/>
            <input type="text" name="first_name" value="<?php echo $_POST['first_name'] ?>" maxlength="45" size="45"> <?php echo $message['first_name']; ?><br/><br/>
            Enter the student's last name:<br/>
            <input type="text" name="last_name" value="<?php echo $_POST['last_name'] ?>" maxlength="45" size="45"> <?php echo $message['last_name']; ?><br/><br/>
            
            <input type="hidden" name= "course" value="<?php echo $_POST['course']?>">
            <input type="submit" name="submit" value="Add this student"><br/><br/>
            
            <?php echo $message['general']; ?>
        </form>

    </main>
  
</body>
</html>