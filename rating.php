<?php 
session_start();
if(isset($_POST['understanding']))  {
  //process a rating with some dummy data
  //$date = htmlspecialchars(trim($_POST[now()]));
    $section_id = htmlspecialchars(1);
    
    //database connection info
    $host = "209.236.71.62";
    $user = "mrgogor3_PRJXUSR";
    $pass = "query370?Dinah";
    $db = "mrgogor3_PRJX";
    $port = 3306;
    
    $understanding = $_POST[understanding];
    $engagement = $_POST[engagement]; 
    $overall = $_POST[overall];    
    
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
       <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"><!--I will change understanding to the actual categories... IF WE HAD ANY AAGGWREG -->
           <br><h2>Understanding</h2>
           <input type="radio" name="understanding" value="1">
           <input type="radio" name="understanding" value="2">
           <input type="radio" name="understanding" value="3">
           <input type="radio" name="understanding" value="4">
           <input type="radio" name="understanding" value="5">
           <br><h2>Understanding</h2>
           <input type="radio" name="engagement" value="1">
           <input type="radio" name="engagement" value="2">
           <input type="radio" name="engagement" value="3">
           <input type="radio" name="engagement" value="4">
           <input type="radio" name="engagement" value="5">
           <br><h2>Understanding</h2>
           <input type="radio" name="overall" value="1"> 
           <input type="radio" name="overall" value="2">
           <input type="radio" name="overall" value="3">
           <input type="radio" name="overall" value="4">
           <input type="radio" name="overall" value="5">
           <br>
           <input type="submit" name="submit" value="Add">
       </form>
    </main>
     <a href="home.php"><button type="button">Cancel</button></a>
  
</body>
</html>
