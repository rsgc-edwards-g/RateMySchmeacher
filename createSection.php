<?php

// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {
    $teacher_id = $_SESSION['id'];
    $provided_id = htmlspecialchars(trim($_POST['sect_id']));
    $provided_cycle_day = htmlspecialchars(trim($_POST['cycle_day']));
    $provided_course = htmlspecialchars(trim($_POST['course_name']));

    // Verify that user_id, name, email, and password were provided.
    if (strlen($provided_id) == 0) {
        $message['sect_id'] = "Section ID is required.";
    }
    if (strlen($provided_cycle_day) == 0) {
        $message['cycle_day'] = "Cycle day is required.";
    }
    if (strlen($provided_course) == 0) {
        $message['course_name'] = "Course name is required.";
    }
    
    $query = "SELECT * FROM course;";
    $result = mysqli_query($connection, $query);
    
    $output = "<h2>Available Courses</h2>";
    while ($row = mysqli_fetch_assoc($result)) {
        $output .= "<a href=\"./course/?cid=" . urlencode($row['id']) . "\">" . $row['code'] . ": " . $row['name'] . "</a>";
    }

    
    
    // If there were no errors on basic validation of input, proceed
    if (!isset($message)) {
        
        // Connect to database
        $host = "209.236.71.62";
        $user = "mrgogor3_PRJXUSR";
        $pass = "query370?Dinah";
        $db = "mrgogor3_PRJX";
        $port = 3306;
        
        // Establish the connection
        // (note username and password here is the *database* username and password, not for a user of this website)
        $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
        
            
       // Verify that section not already created
        $query = "SELECT name FROM section WHERE id == " . $teacher_id . " AND WHERE cycle_day == " . $provided_cycle_day . ";" ;
        $result = mysqli_query($connection, $query);
        if (! $row = mysqli_fetch_assoc($result) ) {
            $query = "INSERT INTO section (id, cycle_day, teacher_id, course_id) VALUES (" . $teacher_id . ", " . $provided_cycle_day . ", " . $provided_username . ", " . $provided_course . ")";

            // Check to see if query succeeded
            if (! mysqli_query($connection, $query)) {
                // Show an error message, something unexpected happened (query should succeed)
                $message['general'] = "We could not create your section at this time. Please try again later.";
            } else {
                // All is well, re-direct to the page where the user can log in.
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'indexTeacher.php';
                header("Location: http://$host$uri/$extra");
                exit;
            }
            
        } else {
            
            // Throw an error, section already exists with this username
            $message['username'] = "That section has been created. Please select another.";
        }
 
    }
}

?>

<html lang="en">
    
<head>
    <meta charset="utf-8">
    <title>Create Section</title>
    
</head>
    <header>
        Course Section Creation
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Enter your desired Section ID:<br/>
            <input type="text" name="sect_id" value="<?php echo $_POST['sect_id'] ?>" maxlength="45" size="45"> <?php echo $message['sect_id']; ?><br/><br/>
            Enter your Section's Cycle Day:<br/>
            <input type="text" name="cycle_day" value="<?php echo $_POST['cycle_day'] ?>" maxlength="45" size="45"> <?php echo $message['cycle_day']; ?><br/><br/>
            Create a User ID:<br/>
            <input type="text" name="course_name" value="<?php echo $_POST['course_name'] ?>" maxlength="45" size="45"> <?php echo $message['course_name']; ?><br/><br/>
            
            <input type="submit" name="submit" value="Create new section"><br/><br/>
            
            <?php echo $message['general']; ?>
        </form>
        </form>
    </main>

</html>
