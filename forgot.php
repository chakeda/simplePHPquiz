<?php
/**
 * Password reset script.
 */
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies: Password Reset</title>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script> 
    </head>
	
    <body>
        <p>
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
        </p>
	<div id="content">
	<div id="os_content">

<br />
<br />
<form method="post" action="forgotprocess.php"  name="forgotprocess.php" >
    <p>Forgot Your Password?</p>
	<p>Enter your email and click submit.</p>
    <p>We will email you a randomly generated password.</p>
    <p><input type="text" name="email" id="email" /></p>
    <p><input type='submit' name='submit' id='submit' /></p>
</form>


	<p>Back to <a href='quizhome.php'>Dashboard</a></p>

	<p>Don't have a login? <a href='register.php'>Register</a></p>
	
	</div>
	</div>
    </body>
	</html>
