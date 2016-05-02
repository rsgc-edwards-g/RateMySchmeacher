<?php 

  session_start();
  
  
  if(!isset($_SESSION['username'])){
      // Not logged in, re-direct to the login page
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'indexTeacher.php';
      header("Location: http://$host$uri/$extra");
      exit;
  }
  //print_r($_SESSION['checked']);
  //die();
  
  if ($_SESSION['checked'] = "AUTHORIZED"){
  
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
     
      // Right now I'm going to just give all students without a set password a random password
      // Uses a subquery to narrow down how many id's are returned
      $user_query = "SELECT s.id FROM students s WHERE password = '' AND s.id NOT IN (SELECT sip.students_id FROM stu_initial_passwords sip);";
      $user_result = mysqli_query($connection, $user_query);
      
      // go through all the results 
      while ($row = mysqli_fetch_assoc($user_result)){
   
        $rand_pass = '';
        $characters = "0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
      
        for ($i=0;$i<6;$i++){
          $rand_pass .= $characters[rand(0, strlen($characters))];
        }
      
        $insert_query = "INSERT INTO stu_initial_passwords (rand_pass, students_id) VALUES ('" . $rand_pass . "', " . $row['id'] . ");";
        $insert_result = mysqli_query($connection, $insert_query);
      }
      
      // The query in the bracket is a subquery that is run first. This query will find all the teachers without a password in either teacher or initial passwords
      $teacher_query = "SELECT t.id FROM teacher t WHERE password = '' AND t.id NOT IN (SELECT tip.teacher_id FROM teacher_initial_passwords tip);";
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
      
      
      $_SESSION['checked'] = "NOT";
      
      $host  = $_SERVER['HTTP_HOST'];
      $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
      $extra = 'homeTeacher.php';
      header("Location: http://$host$uri/$extra");
      exit;
    
  } 
     
  } else {
    
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'check.php';
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
