<?php
/**
 * When people try to access quiz.php without being logged in, they are redirected here.
 * 
 */
include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();

?>
<!DOCTYPE html>
<html>
    
    <head>
        <title>Student Leadership Competencies: Log In</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> <!-- Actual used stylesheet -->
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
    
    <body>
        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
	<div id="content">
	<div id="os_content">

        <?php
        if (isset($_GET['error'])) {
            echo '<p class="error">Error Logging In!</p>';
        }
        ?>        
        <br />
        
        <style type="text/css">
            
            table, tr, td{
                border: 0px solid gray;
            }    
            
            button, input[type="button"], input[type="submit"] { 
                background-color:#F26522; 
                color:white;
            } 
            
        </style>
        <?php if (login_check($mysqli) == true){ echo '<p>Welcome '.htmlentities($_SESSION['username']).'!</p>';} ?>
        <form action="includes/process_login.php" method="post" name="login_form">
        <table width="30%" align="center">
            <tr>
            <td>Email:</td> <td><input type="text" name="email"/></td>
            </tr>
            <tr>
            <td>Password:</td> <td><input type="password" 
                             name="password" 
                             id="password"/></td>
            </tr>
            <tr><td colspan="2"><p><input type="button" 
                   value="Login"
                   onclick="formhash(this.form, this.form.password);" /></p></td></tr>
        </table>

        </form>
        <br />
        <h2><u>Dashboard</u></h2>
        <?php if (login_check($mysqli) == false){ echo '<p>You must be logged in to take the Inventory.</p>'; } ?>
        <?php if (login_check($mysqli) == false){ echo '<p>If you don\'t have a login, please <a href="register.php">register</a></p>'; } ?>
        
        <?php if (login_check($mysqli) == true){ echo '<p><strong><a href="quiz.php">Take the Inventory</a></strong></p>'; } ?>
        <?php if (login_check($mysqli) == true){ echo '<p><a href="results.php">See Your Results</a></p>'; } ?>
        <?php if (login_check($mysqli) == true){ echo '<p><a href="changepass.php">Change your password</a></p>'; } ?>
	<p><a href="forgot.php">Forgot Password?</a></p>
        <br />
        <?php if (login_check($mysqli) == true){ echo '<p>If you are done, please <a href="includes/logout.php">log out</a>.</p>'; } ?>
	<p>The Student Leadership Competencies Inventory is a self-evaluation tool to help you

discover your areas of strength and areas of development for the 60 Student Leadership 

Competencies.
        </p>
        </div>
	</div>
        

        
        <p><br />
            <img src="includes/SLC infographic.png" alt="SLC infographic" width="800px">
        </p><br />
    </body>
</html>
