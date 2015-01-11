<?php
$error = filter_input(INPUT_GET, 'err', $filter = FILTER_SANITIZE_STRING);

if (! $error) {
    $error = 'Oops! An unknown error happened.';
}
?>
<!DOCTYPE html>
<!--
This is the error page that people will be redirected to if an error occurs. 
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies Inventory User Login: Error</title>
                <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> <!-- Actual used stylesheet -->
    </head>
    <body>
        <p><img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px"></p>
		<div id="content">
		<div id="os_content">

        <h1>There was a problem</h1>
        <p class="error"><?php echo $error; ?></p> 
        <p>Return to <a href="quizhome.php">Dashboard</a></p>           
	    </div>
		</div>
    </body>
</html>
