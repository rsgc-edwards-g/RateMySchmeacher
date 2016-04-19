<?php 

  session_start();
  if(!isset($_SESSION['username']))
  {
      // Not logged in, re-direct to the login page
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'indexTeacher.php';
      header("Location: http://$host$uri/$extra");
      exit;
  }
  
  
  if(isset($_POST['submit'])){
    // Connect to database
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
  
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    $provided_password = htmlspecialchars(trim($_POST['password']));
    if (strlen($provided_password) == 0){
        $message['password'] = "Password is required.";
    } else {
        
        if (password_verify($provided_password, $authorization_password)){
            $_SESSION['checked'] = TRUE;
            $host  = $_SERVER['HTTP_HOST'];
            $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            $extra = 'populate.php';
            header("Location: http://$host$uri/$extra");
            exit;
        } else {
            $message['password'] = "Incorrect password. Please try again.";
        }
    }
      
  }
  
  
    

?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Shmee - Authorization Check</title>

</head>

<body>

    <header>
      <h1>Shmee</h1>
    </header>

    <h1>Authorization Check</h1>
    
    <p>In order to gain access to the 'populate' page, you must enter the authorization password.</p>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <h2>Password:</h2>
        <input type="password" name="password" value="<?php echo $_POST['password']?>" maxlength="40" size="40"> <?php echo $message['password']; ?>
        <br><br><input type="submit" name="submit" value="Confirm"/>
    </form><br>
    <a href="<?= $previous ?>"><button type="button">Cancel</button></a>
   
</body>
</html>
