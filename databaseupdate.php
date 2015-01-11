<?php

// Updates QUESTIONS from admin

include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();
	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SLC - Database Edit</title>
		
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
    </head>
    <body>
        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
	<div id="content">
            <div id="os_content">
            <?php
            if (login_check($mysqli) == true):
                ?><p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                
                <?php
                                
                $query6 = "SELECT * FROM Questions";
                $result6 = mysql_query($query6);
                
                for ($j=1; $j<=mysql_num_rows($result6); $j++){
                    
                    $categoryKey = 'Category' . (string)$j;
                    $questionKey = 'Question' . (string)$j;
                    $competencyKey = 'Competency' . (string)$j;
                    $orderKey = 'Order' . (string)$j;

                    $result7 = $mysqli->prepare("UPDATE Questions SET 
                        Category = ?, 
                        `Order`= ?, 
                        Question= ?,
                        Competency= ?
                        WHERE `id`='$j' 
                    ");
                    $result7->bind_param('ssss', $_POST[$categoryKey], $_POST[$orderKey], $_POST[$questionKey], $_POST[$competencyKey]);
                    $result7->execute();
                     
                }

                if ($result7){
                        echo "<p>Successfully updated database.</p>";
                        echo "<p><a href='admin.php'>Back to Admin</a></p>";
                }else{
                        echo "<p>Error</p>";
                        echo "<p><a href='admin.php'>Back to Admin</a></p>";

                }

                ?>
                
                
                
                 <p>Return to <a href="quizhome.php">Dashboard</a></p>
            <?php else: ?>
                <p>
                <br />
		<br />
                <span class="error">Access Denied</span>.
		<br />
                </p>
                <p>Return to <a href="quizhome.php">Dashboard</a></p>
            <?php
            endif;
            ?>
            </div>
        </div>
    </body>
</html>