<?php
    // Check whether session created (is user logged in?)
    // If not, re-direct to main index page.
    session_start();
    //print_r($_SESSION);
    //die();
    if(!isset($_SESSION['username']))
    {
        // Not logged in, re-direct to the login page
        $host  = $_SERVER['HTTP_HOST'];
        $uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
        $extra = 'index.php';
        header("Location: http://$host$uri/$extra");
        exit;
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
    
    $head_query = "SELECT course_id, section_id FROM section WHERE syst_id = '" . $_POST['course'] . "';";
    $head_result = mysqli_fetch_assoc(mysqli_query($connection, $head_query));
    $class_head = "" . $head_result['course_id'] . "-" . $head_result['section_id'] . "";
    
    // And now perform simple query – make sure it's working
    $query = "SELECT understanding, engaging, productive, date FROM ratings WHERE section_syst_id = '" . $_POST['course'] . "';";
    $result = mysqli_query($connection, $query);
    
    // Iterate over the result set (Note: there are 4 columns in the table for the 4 values we are SELECTING)
    while ($row = mysqli_fetch_assoc($result)) {
        // New row
        $output .= "<tr>";
        // Understanding Column
        $output .= "<td>";
        $output .= $row['understanding'];
        $output .= "</td>";
        // Engaging column
        $output .= "<td>";
        $output .= $row['engaging'];
        $output .= "</td>";
        // Productive column
        $output .= "<td>";
        $output .= $row['productive'];
        $output .= "</td>";
        // Date column
        $output .= "<td>";
        $output .= $row['date'];
        $output .= "</td>";
        $output .= "</tr>";
    }
    
    $ratings_query = "SELECT COUNT(*) FROM ratings WHERE section_syst_id = '" . $_POST['course'] . "';";
    $ratings_result = mysqli_query($connection, $ratings_query);
    $num_ratings = mysqli_fetch_assoc($ratings_result);
    
?>


<!doctype html>

<html lang="en">
<head>
    <script src="http://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer",
		{

			title:{
				text: "Site Traffic",
				fontSize: 30
			},
                        animationEnabled: true,
			axisX:{

				gridColor: "Silver",
				tickColor: "silver",
				valueFormatString: "DD/mm/YYYY"

			},                        
                        toolTip:{
                          shared:true
                        },
			theme: "theme2",
			axisY: {
				gridColor: "Silver",
				tickColor: "silver"
			},
			legend:{
				verticalAlign: "center",
				horizontalAlign: "right"
			},
			data: [
			{        
				type: "line",
				showInLegend: true,
				lineThickness: 2,
				name: "",
				markerType: "square",
				color: "#F08080",
				dataPoints: [
				{ x: new Date(2010,0,3), y: 650 },
				{ x: new Date(2010,0,5), y: 700 },
				{ x: new Date(2010,0,7), y: 710 },
				{ x: new Date(2010,0,9), y: 658 },
				{ x: new Date(2010,0,11), y: 734 },
				{ x: new Date(2010,0,13), y: 963 },
				{ x: new Date(2010,0,15), y: 847 },
				{ x: new Date(2010,0,17), y: 853 },
				{ x: new Date(2010,0,19), y: 869 },
				{ x: new Date(2010,0,21), y: 943 },
				{ x: new Date(2010,0,23), y: 970 }
				]
			},
			{        
				type: "line",
				showInLegend: true,
				name: "Unique Visits",
				color: "#20B2AA",
				lineThickness: 2,

				dataPoints: [
				{ x: new Date(2010,0,3), y: 510 },
				{ x: new Date(2010,0,5), y: 560 },
				{ x: new Date(2010,0,7), y: 540 },
				{ x: new Date(2010,0,9), y: 558 },
				{ x: new Date(2010,0,11), y: 544 },
				{ x: new Date(2010,0,13), y: 693 },
				{ x: new Date(2010,0,15), y: 657 },
				{ x: new Date(2010,0,17), y: 663 },
				{ x: new Date(2010,0,19), y: 639 },
				{ x: new Date(2010,0,21), y: 673 },
				{ x: new Date(2010,0,23), y: 660 }
				]
			}

			
			],
          legend:{
            cursor:"pointer",
            itemclick:function(e){
              if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
              	e.dataSeries.visible = false;
              }
              else{
                e.dataSeries.visible = true;
              }
              chart.render();
            }
          }
		});

chart.render();
}
    </script>
  <meta charset="utf-8">

  <title>Shmee</title>

  <link rel="stylesheet" href="./CSS/Stylin.css?v=1.0">
  
</head>

<body>

    <header>
        <?php include 'headerTeacher.php'; ?>
    </header>
    <h1><?php echo $class_head; ?> Class Page</h1>
    <nav>
        <ul>
            <li><a href="./logout.php">logout</a></li>
            <li>Home</li>
            
        </ul>
    </nav>

    <main>
        <p><a></a></p>

        <h2>Recent Ratings</h2>
        <table>
            <tr>
                <td>Understanding</td>
                <td>Engagement</td>
                <td>Productivity</td>
                <td>Date of Rating</td>
            </tr>
            <?php echo $output ?>
        </table>
        
    </main>
  
</body>
</html>