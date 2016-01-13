<?php




?>

<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Shmee</title>

  <link rel="stylesheet" href="./css/style.css?v=1.0">

</head>

<body>

    <header>
        <ul>
            /* <li><img src="./images/logo-small.png"/></li> */
        </ul>
    </header>

    <main>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            User ID:<br/>
            <input type="text" name="ID" value="<?php echo $_POST['ID'] ?>" maxlength="20" size="20"> <?php echo $message['ID']; ?><br/><br/>
            Password:<br/>
            <input type="password" name="password" value="<?php echo $_POST['password'] ?>" maxlength="20" size="20"> <?php echo $message['password']; ?><br/><br/>
            <input type="submit" name="submit" value="Login">
        </form>
      
        <p>Don't have an account?<br><a href="register.php">create a new account</a></br></p>
    
        <p><?php echo $message['general']; ?></p>
    </main>
  
</body>
</html>
