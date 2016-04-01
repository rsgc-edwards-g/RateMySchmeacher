<?php 
session_start();
if(isset($_POST['understanding']))  {
  //process a rating with some dummy data
    $section_id = htmlspecialchars(1);
    
    //database connection info
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    if(understanding == 1 || 2 || 3 || 4 ||5){
    $understanding = $_POST['understanding'];
    }
    if(engagement == 1 || 2 || 3 || 4 ||5){
    $engagement = $_POST['engagement'];
    }
    if(productive == 1 || 2 || 3 || 4 ||5){
    $overall = $_POST['productive']; 
    }   
    $date = htmlspecialchars(trim($_POST[now()]));
    
    //Adds into database?
    //Change parameters tho
    $query = "INSERT INTO ratings (understanding, engagement, productive, date, syst_id) VALUES ('" . $_POST['understanding'] . "', '" . $_POST['engagement'] . "', '" . $_POST['productive'] . "', '" . $date ."', '" . $_POST['course'] ."');";
    
    
    //this code kills the php process
    //print_r($_POST);
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
           <br><h2>Overall</h2>
           <input type="radio" name="productive" value="1"> 
           <input type="radio" name="productive" value="2">
           <input type="radio" name="productive" value="3">
           <input type="radio" name="productive" value="4">
           <input type="radio" name="productive" value="5">
           <br>
           <input type="submit" name="submit" value="Add">
       </form>
    </main>
     <a href="home.php"><button type="button">Cancel</button></a>
  
</body>
</html>
