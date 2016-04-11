<?php 
session_start();
//print_r($_POST);
//die();

if(isset($_POST['understanding']))  {
  //process a rating with some dummy data
    $section_id = htmlspecialchars(1);
    
    //database connection info
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
    if(understanding == 1 || 2 || 3 || 4 ||5){
    $understanding = $_POST['understanding'];
    }
    if(engagement == 1 || 2 || 3 || 4 ||5){
    $engagement = $_POST['engagement'];
    }
    if(productive == 1 || 2 || 3 || 4 ||5){
    $productive = $_POST['productive']; 
    }   
    
    $date = date(d . "/" . m . "/" . Y);
    
    //Adds into database?
    //Change parameters tho
    $query = "INSERT INTO ratings (students_id, understanding, engaging, productive, date, section_syst_id) VALUES ('" . $_SESSION['id'] . "', '" . $_POST['understanding'] . "', '" . $_POST['engagement'] . "', '" . $_POST['productive'] . "', '" . $date . "', '" . $_POST['course'] ."');";
    $result = mysqli_query($connection, $query);
    
    // All is well, re-direct to the page where the user can log in.
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'home.php';
    header("Location: http://$host$uri/$extra");
    exit;
    
    //this code kills the php process
    //print_r($query);
    //die();
}
       
        
    
?>
<html lang="en">
<head>
  <meta charset="utf-8">
    <link rel="stylesheet" href="CSS/Stylin.css">
  <title>Shmee - Ratings Page</title>
</head>

<body>
    <header>
      <?php include 'header.php'; ?>
    </header>
    <h1>Rating for </h1>
    <main>
       <form action="rating.php" method="post">
           <input type="hidden" name= "course" value="<?php echo $_POST['student']?>">
           <br><h2>Understanding</h2>
           <input type="radio" name="understanding" value="1">
           <input type="radio" name="understanding" value="2">
           <input type="radio" name="understanding" value="3">
           <input type="radio" name="understanding" value="4">
           <input type="radio" name="understanding" value="5">
           <br><h2>Engagement</h2>
           <input type="radio" name="engagement" value="1">
           <input type="radio" name="engagement" value="2">
           <input type="radio" name="engagement" value="3">
           <input type="radio" name="engagement" value="4">
           <input type="radio" name="engagement" value="5">
           <br><h2>Productivity</h2>
           <input type="radio" name="productive" value="1"> 
           <input type="radio" name="productive" value="2">
           <input type="radio" name="productive" value="3">
           <input type="radio" name="productive" value="4">
           <input type="radio" name="productive" value="5">
           <br>
           <input type="submit" name="submit" value="Add">
           <input type="hidden" name="course" value="<?php echo $_POST['course']?>">
       </form>
    </main>
     <a href="home.php"><button type="button">Cancel</button></a>
  
</body>
</html>
