<?php

// This page is a self-submitting form.
// Process the submitted form.
session_start();
if(isset($_POST['submit']))  {
    $provided_username = htmlspecialchars(trim($_POST['username']));
    $provided_initial_password = htmlspecialchars(trim($_POST['initial_pass']));
    $provided_password = htmlspecialchars(trim($_POST['password']));

    // Verify that user_id, name, email, and password were provided.
    if (strlen($provided_username) == 0) {
        $message['username'] = "Username is required.";
    }
    if (strlen($provided_initial_password) == 0) {
        $message['initial_pass'] = "Initial password is required.";
    }
    if (strlen($provided_password) == 0) {
        $message['password'] = "A password is required.";
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
        
            
       
        // Proceed with creating a user based on provided username
        $hashed_password = password_hash($provided_password, PASSWORD_DEFAULT);
        $query = "UPDATE teacher SET password='" . $hashed_password . "' WHERE username = '" . $provided_username . "';";

        // Check to see if query succeeded
        if (! mysqli_query($connection, $query)) {
            // Show an error message, something unexpected happened (query should succeed)
            $message['general'] = "We could not create your account at this time. Please try again later.";
        } else {
        
            $teacher_id_query = "SELECT id FROM teacher WHERE username = '" . $provided_username . "';";
            $teacher_id_result = mysqli_query($connection, $teacher_id_query);
            $teacher_id_row = mysqli_fetch_assoc($teacher_id_result);
            $delete_query = "DELETE FROM teacher_initial_passwords WHERE teacher_id = '" . $teacher_id_row['id'] . "';";
            $delete_result = mysqli_query($connection, $delete_query);
            
            // All is well, re-direct to the page where the user can log in.
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'indexTeacher.php';
            header("Location: http://$host$uri/$extra");
            exit;
        }
            
        } 
 
    }


?>

<html lang="en">
    
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
    <title>Teacher Password Reset</title>
    
</head>

    <main>
        
        <p>Once you've set a new password, you can log in and access all that Shmee has to offer.</p><br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            
            Enter your username:<br/>
            <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="45" size="45"> <?php echo $message['username']; ?><br/><br/>
            Enter your initial password:<br/>
            <input type="text" name="initial_pass" value="<?php echo $_POST['initial_pass'] ?>" maxlength="45" size="45"> <?php echo $message['initial_pass']; ?><br/><br/>
            Enter a new password:<br/>
            <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="45" size="45"> <?php echo $message['password']; ?><br/><br/>
            
            <input type="submit" name="submit" value="Activate account"><br/><br/>
            
            <?php echo $message['general']; ?>
        </form>
        </form>
    </main>

</html>
