<?php

include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();

// notice: database typos intentional -- it is inherited code
	
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>SLC - Admin Page</title>
		
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
    </head>
    <body>
        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
	<div id="admincontent">
            <p>Return to <a href="quizhome.php">Dashboard</a></p>           

            <?php
            if (login_check($mysqli) == true):
                ?><p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
                <h1>Administrative Functions</h1>

                
            <p><strong>Download Data as CSV</strong></p>
            <p>Please enter Dates in YYYY-MM-DD format. </p>
            <form id="csvdownload" method="post" action="download.php" style="text-align:center">
                Start Date: <input type="text" name="start" id="start" />
                End Date:   <input type="text" name="end" id="end" />
                <input type="Submit" value="Download"/>
            </form>
            
            
            <br />
            <br />
            <br />
            <br />
            <!-- More functions to come -->
            <p><strong>Edit Database</strong></p>
            <p>Edit any value and hit submit button to make changes to the entire database.</p>
            <p>Note that `Order` field does not affect this web application.</p>
            
            
            <?php
            // begin code for giant editable form
            echo '<br /><h2> Questions DATABASE </h2>';
            
            $query = "SELECT * FROM Questions";
            $result = mysql_query($query);

            echo '<form name="input" action="databaseupdate.php" method="POST" style="text-align:center">';
            echo '<p>Category, Order, Question, Competency</p>';
            
           $i = 1;
           while ($row = mysql_fetch_array($result)) {
               ?> 
               <input type="text" name="Category<?php echo $i; ?>" value="<?php echo $row[Category]; ?>">
               <input type="text" size="5" name="Order<?php echo $i; ?>" value="<?php echo $row[Order]; ?>">
               <input type="text" size="105" name="Question<?php echo $i; ?>" value="<?php echo $row[Question]; ?>">
               <input type="text" name="Competency<?php echo $i; ?>" value="<?php echo $row[Competency]; ?>">
               <br /><br />

               <!--
               echo "<input type='text' size='5' name='Order".$i."' value='".$row[Order]."'>    ";
               echo "<input type='text' size='105' name='Question".$i."' value='".$row[Question]."'>    ";
               echo "<input type='text' name='Competency".$i."' value='".$row[Competency]."'>    ";
               echo "<br /><br />";
               -->
               <?php
               $i++;
           }
           echo '<input type="submit" value="Submit `Questions` database changes" >';
           echo '</form>';

           

           
           echo '<br /><br /><br /><br /><h2> SkillDiscriptions(sic) DATABASE </h2>';
           echo '<form name="input2" action="databaseupdate2.php" method="POST" style="text-align:center">';
           echo '<p>Skill, Category, Description</p>';
           
           $query2 = "SELECT * FROM SkillDiscriptions1";
           $result2 = mysql_query($query2);
           
           $k = 1;
           while ($row2 = mysql_fetch_array($result2)) {
                              
               ?>
               <input type="text" name="Skill<?php echo $k; ?>" value="<?php echo $row2[Skill]; ?>">
               <input type="text" name="Catagory<?php echo $k; ?>" value="<?php echo $row2[Catagory]; ?>">
               <input type="text" size="110" name="Discription<?php echo $k; ?>" value="<?php echo $row2[Discription]; ?>">
               <br /><br />
               <!--
               echo "<input type='text' name='Skill".$k."' value='".$row2[Skill]."'>    ";
               echo "<input type='text' name='Catagory".$k."' value='".$row2[Catagory]."'>    ";
               echo "<input type='text' size='110' name='Discription".$k."' value='".$row2[Discription]."'>    ";
               echo "<br /><br />";
               -->
               <?php
               $k++;
           }

           echo '<input type="submit" value="Submit `SkillDiscriptions` database changes" >';
           echo '</form>';
           
           ?>
            
            
            
            <p>Return to <a href="quizhome.php">login page</a></p>
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
    </body>
</html>