<?php

// UPDATES SkillDiscriptions from admin

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
                        
                $query3 = "SELECT * FROM SkillDiscriptions1";
                $result3 = mysql_query($query3);
                               
                for ($h=1; $h<=mysql_num_rows($result3); $h++){
                    
                    // Again, whoever made this database should use spell check
                    $skillKey = 'Skill' . (string)$h;
                    $catagoryKey = 'Catagory' . (string)$h;
                    $discriptionKey = 'Discription' . (string)$h;

                    // have to prepare so I don't sql inject myself.
                    $result4 = $mysqli->prepare("UPDATE SkillDiscriptions1 SET 
                        Skill = ?, 
                        Catagory = ?, 
                        Discription = ?
                        WHERE id='$h'
                    ");
                    $result4->bind_param('sss', $_POST[$skillKey], $_POST[$catagoryKey], $_POST[$discriptionKey]);
                    $result4->execute();
                     
                }

                if ($result4){
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