<?php

// This page is a self-submitting form.
// Process the submitted form.
if(isset($_POST['submit']))  {
    $provided_username = htmlspecialchars(trim($_POST['username']));
    $provided_first_name = htmlspecialchars(trim($_POST['first_name']));
    $provided_last_name = htmlspecialchars(trim($_POST['last_name']));
    $provided_email = htmlspecialchars(trim($_POST['email']));
    $provided_password = htmlspecialchars(trim($_POST['password']));

    // Verify that user_id, name, email, and password were provided.
    if (strlen($provided_username) == 0) {
        $message['username'] = "Username is required.";
    }
    if (strlen($provided_first_name) == 0) {
        $message['first_name'] = "First name is required.";
    }
    if (strlen($provided_last_name) == 0) {
        $message['last_name'] = "Last name is required.";
    }
    if (strlen($provided_email) == 0) {
        $message['email'] = "Email is required.";
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
        
            
       // Verify that username not already created
        $query = "SELECT * FROM teacher WHERE username = '" . $provided_username . "';";
        $result = mysqli_query($connection, $query);
        if (! $row = mysqli_fetch_assoc($result) ) {
            // Proceed with creating a user based on provided username
            $hashed_password = password_hash($provided_password, PASSWORD_DEFAULT);
            $query = "INSERT INTO teacher (first_name, last_name, username, password, email) VALUES ('" . $provided_first_name . "', '" . $provided_last_name . "', '" . $provided_username . "', '" . $hashed_password . "', '" . $provided_email . "')";

            // Check to see if query succeeded
            if (! mysqli_query($connection, $query)) {
                // Show an error message, something unexpected happened (query should succeed)
                $message['general'] = "We could not create your account at this time. Please try again later.";
            } else {
                // All is well, re-direct to the page where the user can log in.
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'index.php';
                header("Location: http://$host$uri/$extra");
                exit;
            }
            
        } else {
            
            // Throw an error, user already exists with this username
            $message['username'] = "That username is taken. Please select another.";
        }
 
    }
}

?>

<html lang="en">
    
<head>
    <meta charset="utf-8">
    <title>Register</title>
    
</head>
    <header>
        Teacher Register
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            Enter your First name:<br/>
            <input type="text" name="first_name" value="<?php echo $_POST['first_name'] ?>" maxlength="45" size="45"> <?php echo $message['first_name']; ?><br/><br/>
            Enter your Last name:<br/>
            <input type="text" name="last_name" value="<?php echo $_POST['last_name'] ?>" maxlength="45" size="45"> <?php echo $message['last_name']; ?><br/><br/>
            Create a User ID:<br/>
            <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="45" size="45"> <?php echo $message['username']; ?><br/><br/>
            Enter your email:<br/>
            <input type="text" name="email" value="<?php echo $_POST['email'] ?>" maxlength="45" size="45"> <?php echo $message['email']; ?><br/><br/>
            Enter a password:<br/>
            <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="45" size="45"> <?php echo $message['password']; ?><br/><br/>
            
            <input type="submit" name="submit" value="Create new account"><br/><br/>
            
            <?php echo $message['general']; ?>
        </form>
        </form>
    </main>

</html>
