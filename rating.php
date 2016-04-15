<?php 
session_start();
//print_r($_POST);
//die();
//database connection info
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    // Establish the connection
    // (note username and password here is the *database* username and password, not for a user of this website)
    $connection = mysqli_connect($host, $user, $pass, $db, $port) or die(mysql_error());
    
$head_query = "SELECT course_id, section_id FROM section WHERE syst_id = '" . $_POST['course'] . "';";
$head_result = mysqli_fetch_assoc(mysqli_query($connection, $head_query));
$class_head = "" . $head_result['course_id'] . "-" . $head_result['section_id'] . "";
    

if(isset($_POST['understanding']))  {
  //process a rating with some dummy data
    $section_id = htmlspecialchars(1);
   
    if($_POST['understanding'] == 1 || 2 || 3 || 4 ||5){
        $understanding = $_POST['understanding'];
    } 
    if($_POST['engagement'] == 1 || 2 || 3 || 4 ||5){
        $engagement = $_POST['engagement'];
    } 
    if($_POST['productive'] == 1 || 2 || 3 || 4 ||5){
        $productive = $_POST['productive']; 
    } 
    
    if (isset($understanding) & isset($productive) & isset($engagement)){
    
    $date = date(d . "/" . m . "/" . Y);
    
    //Adds into database?
    //Change parameters tho
    $query = "INSERT INTO ratings (students_id, understanding, engaging, productive, date, section_syst_id) VALUES ('" . $_SESSION['id'] . "', '" . $understanding . "', '" . $engagement . "', '" . $productive . "', '" . $date . "', '" . $_POST['course'] ."');";
    $result = mysqli_query($connection, $query);
    //print_r($query);
    //die();
    
    // All is well, re-direct to the page where the user can log in.
    $host  = $_SERVER['HTTP_HOST'];
    $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
    $extra = 'home.php';
    header("Location: http://$host$uri/$extra");
    exit;
    } 
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
    <h1>Rating for <?php echo $class_head ?></h1>
    <main>
       <form action="rating.php" method="post">
           <input type="hidden" name= "course" value="<?php echo $_POST['student']?>">
           <br><h2><strong>Understanding</strong></h2> 
           Low 
           <input type="radio" name="understanding" value="1">
           <input type="radio" name="understanding" value="2">
           <input type="radio" name="understanding" value="3">
           <input type="radio" name="understanding" value="4">
           <input type="radio" name="understanding" value="5"> 
           High
           <br><h2><strong>Engagement</strong></h2>
           Low
           <input type="radio" name="engagement" value="1">
           <input type="radio" name="engagement" value="2">
           <input type="radio" name="engagement" value="3">
           <input type="radio" name="engagement" value="4">
           <input type="radio" name="engagement" value="5">
           High
           <br><h2><strong>Productivity</strong></h2>
           Low
           <input type="radio" name="productive" value="1"> 
           <input type="radio" name="productive" value="2">
           <input type="radio" name="productive" value="3">
           <input type="radio" name="productive" value="4">
           <input type="radio" name="productive" value="5">
           High
           <br>
           <input type="submit" name="submit" value="Add">
           <input type="hidden" name="course" value="<?php echo $_POST['course']?>">
           <br> <?php echo $message['general']; ?>
       </form>
    </main>
     <a href="home.php"><button type="button">Cancel</button></a>
  
</body>
</html>