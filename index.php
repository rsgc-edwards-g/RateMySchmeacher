<?php
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
    $provided_username = htmlspecialchars(trim($_POST['username']));
    $provided_password = htmlspecialchars(trim($_POST['password']));
    $query = "SELECT password, id FROM students WHERE username = ('" . $provided_username . "');";
    
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
          if (password_verify($provided_password, $stored_password)) {
                // All is well, set the session
                session_start();
                $_SESSION['username'] = $provided_username; 
                $id_query = "SELECT id FROM students WHERE username = ('" . $provided_username . "');";
                $id_result = mysqli_query($connection, $id_query);
                $stu_id = mysqli_fetch_assoc($id_result);
                $_SESSION['id'] = $stu_id['id'];
                
                // Now re-direct to the logged-in home page
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'home.php';
                header("Location: http://$host$uri/$extra");
                exit;
          } else {
              $first_login_query = "SELECT rand_pass FROM stu_initial_passwords WHERE students_id = '" . $row['id'] . "';";
              $login_result = mysqli_query($connection, $first_login_query);
              
              $new_row = mysqli_fetch_assoc($login_result);
              if ($provided_password = $new_row['rand_pass']){
                $host  = $_SERVER['HTTP_HOST'];
                $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
                $extra = 'register.php';
                header("Location: http://$host$uri/$extra");
                exit;
              } else {
              $message['general'] = "Incorrect password for user <strong>" . $provided_username . "</strong>.";
          }
        }
    }
    }
}


?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Shmee - Student Login</title>

</head>

<body>

    <header>
      <h1>Student Login</h1>
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <h2>Student User ID:</h2>
            <input type="text" name="username" value="<?php echo $_POST['username'] ?>" maxlength="20" size="20"> <?php echo $message['username']; ?>
            <h2>Password:</h2>
            <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="20" size="20"> <?php echo $message['password']; ?>
            <br><br><input type="submit" name="submit" value="Login">
        </form>
      

        <!--<p>Haven't activated your account yet?<br><a href="register.php">Activate Now</a></br></p>-->
        <p>Are you a teacher? <br><a href="indexTeacher.php">Login here</a></p><br>
        <p><a href="About.php">About Shmee</a></p>
        <p><?php echo $message['general']; ?></p>
    </main>
  
</body>
</html>
