<?php
/**
 * Quiz. The core of the application. Protected page (requires login)
 */
include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies Inventory</title>
		
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
        
    </head>
    <body>
        <script type="text/javascript">
            function validateForm() {
                var radios = document.getElementsByName("140");
                var formValid = false;

                var i = 0;
                while (!formValid && i < radios.length) {
                    if (radios[i].checked) formValid = true;
                    i++;        
                }

                if (!formValid){ 
                    alert("You must answer all questions. "); 
                }
                return formValid;
            }
        </script>
        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
        <p>Return to <a href="quizhome.php">Dashboard</a></p>
            <?php
            if (login_check($mysqli) == true):
                ?><p>Welcome <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>
<!----------- STARTING QUIZ CODE ------------------------------> 

</br>
<div id ="content">
</br>
<a href="http://www.studentleadershipcompetencies.com">
</a>	
For each of the following statements, indicate a score using the scale below to rate your competency level. Make sure all questions contain a response. To enter a score, click on the corresponding circle under the score you would like to enter.</br></br>
1=Strongly Disagree</br>
2=Disagree</br>
3=Neutral</br>
4=Agree</br>
5=Strongly Agree</br>
</br>

<style type="text/css">
tr.d0 td {
	background-color: #e5e9f0; color: black;
}
tr.d1 td {
	}
td{
padding:2px;
}
</style>
</div>
<?php
    
    // Kite C: converted to mysqli, secure connection practices, cleaned code
    if ($mysqli->connect_errno > 0) {
        die('Unable to connect to database [' . $mysqli->connect_error . ']');
    }

    $listQuestions = $mysqli->query("SELECT DISTINCT Question FROM Questions");
    $numQuestions  = mysqli_num_rows($listQuestions);
    function mysqli_result($res, $row, $field = 0){ //same function as mysql_result()
        $res->data_seek($row);
        $datarow = $res->fetch_array();
        return $datarow[$field];
    }
    
    if ($numQuestions == 0) {
        echo "NONE";
        mysqli_close($mysqli);
    }
    
    $i = 0;
    echo '<div align="center">';
    echo "<form name='thequiz' action='results.php' onsubmit='return validateForm()' method='POST' >";
    echo '<table style="width:70%" ><tr><td></td><td></td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>';
    while ($i < $numQuestions) {
        
        $Question = mysqli_result($listQuestions, $i, "Question");
        
        echo "<tr ";
        if ($i % 2 == 0){ echo "class='d0'";}
        else{ echo "class='d1'";}
        
        echo "><td>" . ($i + 1) . "</td><td>" . $Question . 
                "</td><td><input type=radio name=" . $i .
                " value=1></td><td><input type=radio name=" . $i . 
                " value=2></td><td><input type=radio name=" . $i . 
                " value=3></td><td><input type=radio name=" . $i . 
                " value=4></td><td><input type=radio name=" . $i . 
                " value=5></td></tr>";
        
        $i++;
    }
    echo "<input type='hidden' name='post_id' value='".createPassword(64)."'>"; // used to prevent resubmission
    echo "</table></br></br><input type='submit' value='Submit' /></form></br></br>";
    echo '</div>';
    
?>

<!----------------------- End quiz code ---------------------->

            </p>
            <p>Return to <a href="quizhome.php">Dashboard</a></p>
            <?php else: ?>
                <script>window.location = "quizhome.php";</script>
                <!-- 
                <p><img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
                <br />
		<br />
                <span class="error">You must be logged in to take the Student Leadership Competency Inventory.</span> Please <a href="quizhome.php">login</a>.
		<br />
                </p>
                --> 
            <?php
            endif;
            ?>

    </body>
</html>