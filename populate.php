<?php 

  // Make a password to access this page, if the password given is incorrect, redirect to the previous page

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

  $previous = "javascript:history.go(-1)";
  if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
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
    
  if(isset($_POST['submit'])){
    // We could link this from the register page to give students a random password 
    // Right now I'm going to just give all students without a set password a random password
    $user_query = "SELECT id FROM students WHERE password = '';";
    $user_result = mysqli_query($connection, $user_query);
    while ($row = mysqli_fetch_assoc($user_result)){
      $rand_pass = '';
      $characters = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
    
      for ($i=0;$i<6;$i++){
        $rand_pass .= $characters[rand(0, strlen($characters))];
      }
    
      $insert_query = "INSERT INTO stu_initial_passwords (rand_pass, students_id) VALUES ('" . $rand_pass . "', " . $row['id'] . ");";
      $insert_result = mysqli_query($connection, $insert_query);
      
    
    }
    
    $teacher_query = "SELECT id FROM teacher WHERE password = '';";
    $teacher_result = mysqli_query($connection, $teacher_query);
    while ($teacher_row = mysqli_fetch_assoc($teacher_result)){
      $rand_teacher_pass = '';
      $charset = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      
      for ($j=0;$j<6;$j++){
        $rand_teacher_pass .= $charset[rand(0, strlen($charset))];
      }
      
      $insert = "INSERT INTO teacher_initial_passwords (random_pass, teacher_id) VALUES ('" . $rand_teacher_pass . "', " . $teacher_row['id'] . ");";
      $result = mysqli_query($connection, $insert);
    }
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'homeTeacher.php';
    header("Location: http://$host$uri/$extra");
    exit;
    
    
  }
    

?>

<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Shmee - User Password Reset</title>

</head>

<body>

    <header>
      <h1>Shmee</h1>
    </header>

    <h1>WARNING!</h1>
    <h2>This page will effectively wipe out all temporary passwords in the database. If you wish to do this, click the 'Confirm' button. If you do not wish to do this, click the 'Cancel' button.</h2>
    
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <input type="submit" name="submit" value="Confirm"/>
    </form><br>
    <a href="<?= $previous ?>"><button type="button">Cancel</button></a>
   
</body>
</html>
