<?php
    // Start the session
    session_start();
// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {
    $teacher_id = $_SESSION['id'];
    $provided_cycle_day = htmlspecialchars(trim($_POST['cycle_day']));
    $provided_course = htmlspecialchars(trim($_POST['course_name']));
    $provided_period = htmlspecialchars(trim($_POST['period']));

    // Verify that user_id, name, email, and password were provided.
    if (strlen($provided_cycle_day) == 0) {
        $message['cycle_day'] = "Cycle day is required.";
    }
    if (strlen($provided_course) == 0) {
        $message['course_name'] = "Course name is required.";
    }
    if (strlen($provided_period) == 0) {
        $message['period'] = "Period is required.";
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
        $query = "SELECT id FROM section WHERE teacher_id = " . $teacher_id . " AND cycle_day = " . $provided_cycle_day . " AND period = " . $provided_period . ";" ;
        // print_r($query);
        // die();
        $result = mysqli_query($connection, $query);
        if (! $row = mysqli_fetch_assoc($result)) {
            $course_query = "SELECT id FROM course WHERE name = '" . $provided_course . "';";
            $course_result = mysqli_query($connection, $course_query);
            if ($course_result == false){
               $message['general'] = "There is no such course. Please try again.";
            } else if (mysqli_num_rows($course_result) != 1){
                $message['general'] = "An unexpected error occured. Please try again later.";
            } else {
                $row = mysqli_fetch_assoc($course_result);
                $course_id = $row['id'];
            }
            $entry_query = "INSERT INTO section (cycle_day, teacher_id, course_id, period) VALUES (" . $provided_cycle_day . ", " . $teacher_id . ", " . $course_id . ", " . $provided_period . ");";
            //$result_entry = mysqli_query($connection, $entry_query);
            //print_r($entry_query);
            //die();
            
            // Check to see if query succeeded
            if (! mysqli_query($connection, $entry_query)) {
                // Show an error message, something unexpected happened (query should succeed)
                $message['general'] = "We could not create your section at this time. Please try again later.";
            } else {
                // All is well, re-direct to the home page.
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'homeTeacher.php';
                header("Location: http://$host$uri/$extra");
                exit;
            }
            
        } else {
            
            // Throw an error, section already exists with these specifications
            $message['general'] = "That section has been created. Please select another.";
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
        <?php include 'headerTeacher.php'; ?>
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Enter your course name:<br/>
            <input type="text" name="course_name" value="<?php echo $_POST['course_name'] ?>" maxlength="45" size="45"> <?php echo $message['course_name']; ?><br/><br/>
            Enter your section's cycle day (1 or 2):<br/>
            <input type="text" name="cycle_day" value="<?php echo $_POST['cycle_day'] ?>" maxlength="45" size="45"> <?php echo $message['cycle_day']; ?><br/><br/>
            Enter your class period on the listed day:<br/>
            <input type="text" name="period" value="<?php echo $_POST['period'] ?>" maxLength = "45" size="45"> <?php echo $message['period']; ?><br/><br/>

            <input type="submit" name="submit" value="Create new section"><br/><br/>
            
            <?php echo $message['general']; ?>
        </form>
        </form>
    </main>

</html>
