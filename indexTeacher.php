<?php
    session_start();
    if(isset($_POST['submit']))  {

    // DB Connection Parameters

    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection with database user names and passwords
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    // Process a log in
    $provided_username = htmlspecialchars($_POST['username']);
    $provided_password = htmlspecialchars($_POST['password']);
    $query = "SELECT password FROM teacher WHERE username = ('" . $provided_username . "');";
    
    // Get results
    $result = mysqli_query($connection, $query);
    
    // Compare the provided password to the stored password
    if ($result == false) {
        $message['general'] = "An unexpected error occurred. Please try again later.";
    } else {
        if (mysqli_num_rows($result) == 0) {
          $message['general'] = "Error. The user <strong>" . $provided_username . "</strong> was not found.";
        } else {
          // We have a result, now do the comparison of passwords
          $row = mysqli_fetch_assoc($result);
          $stored_password = $row['password'];
          if (password_verify($provided_password, $stored_password) == true) {
                // All is well, set the session
                session_start();
                $_SESSION['username'] = $provided_username; 
                $id_query = "SELECT id FROM teacher WHERE username = ('" . $provided_username . "');";
                $id_result = mysqli_query($connection, $id_query);
                $_SESSION['id'] = mysqli_fetch_assoc($id_result)['id'];
                
                // Now re-direct to the logged-in home page
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'homeTeacher.php';
                header("Location: http://$host$uri/$extra");
                exit;
          } else {
              $message['general'] = "Incorrect password for user <strong>" . $provided_username . "</strong>.";
          }
        }
    }
    
}


?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Shmee</title>

</head>

<body>

    <header>
        Shmee
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            User ID:<br/>
            <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="20" size="20"> <?php echo $message['username']; ?><br/><br/>
            Password:<br/>
            <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="20" size="20"> <?php echo $message['password']; ?><br/><br/>
            <input type="submit" name="submit" value="Login">
        </form>
      
        <p>Haven't activated your account yet?<br><a href="registerTeacher.php">Activate Now</a></br></p>
    
        <p><?php echo $message['general']; ?></p>
    </main>
  
</body>
</html>
