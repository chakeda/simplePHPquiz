<?php
/**
 * Password reset processes.
 * This file's code is weird because I built it off something I found online.
 * but it works be generating a random password, sending it to the user,
 * hashing the password, and sending it to the database. 
 * Was very difficult to integrate with the login system. 
 */
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);

$email = $_POST['email'];
include_once "includes/functions.php";
include_once "includes/connect.php"; 
$site_url = "http://www.studentleadershipcompetencies.com/";
sec_session_start();

?>

<!DOCTYPE html>
<html>
<head>
<title>Student Leadership Competencies: Password Reset</title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> 
<script type="text/JavaScript" src="js/sha512.js"></script> 
<script type="text/JavaScript" src="js/forms.js"></script> 
</head>
<body>
    	<div id="content">
	<div id="os_content">
            <br />
            <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
            <br />

<?php

$status = "OK";
$msg    = "test";

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg    = "Your email address is not correct<BR>";
    $status = "NOTOK";
}


echo "<br><br>";
if ($status == "OK") {
    $count = $dbo->prepare("SELECT email,username,salt FROM members WHERE members.email = '$email'");
    $count->execute();
    $row = $count->fetch(PDO::FETCH_OBJ);
    $no  = $count->rowCount();
    //echo " No of records = ".$no; 
    
    $em = $row->email; // email is stored to a variable
    if ($no == 0) {
        echo "<b>No Password</b><br>Your address is not in our database . You must register and login to take the quiz. <BR><BR><input type='button' value='Retry' onClick='history.go(-1)'> . <a href='register.php'> Sign UP </a>";
        exit;
    }
    
    /////////////// Let us send the email with key /////////////
    /// function to generate random number ///////////////
    function random_generator($digits)
    {
        srand((double) microtime() * 10000000);
        //Array of alphabets
        $input = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
        
        $random_generator = ""; // Initialize the string to store random numbers
        for ($i = 1; $i < $digits + 1; $i++) { // Loop the number of times of required digits
            
            if (rand(1, 2) == 1) { // to decide the digit should be numeric or alphabet
                // Add one random alphabet 
                $rand_index = array_rand($input);
                $random_generator .= $input[$rand_index]; // One char is added
                
            } else {
                
                // Add one numeric digit between 1 and 10
                $random_generator .= rand(1, 10); // one number is added
            } // end of if else
            
        } // end of for loop 
        
        return $random_generator;
    } // end of function
    
    
    $key = random_generator(10);
    //print_r($sql->errorInfo()); 
    
    $headers4 = "admin@studentleadershipcompetencies.com"; ///// Change this address within quotes to your address ///
    $headers .= "Reply-to: $headers4\n";
    $headers .= "From: $headers4\n";
    $headers .= "Errors-to: $headers4\n";
    //$headers = "Content-Type: text/html; charset=iso-8859-1\n".$headers;// for html mail un-comment this line
    //$site_url = $site_url . "activepassword.php?ak=$key&userid=$row->userid";
	$site_url = $site_url . "quizhome.php";
    //echo $site_url;
    if (mail("$em", "Password Reset for Studentleadershipcompetencies.com", "This is in response to your request for password reset at studentleadershipcompetencies.com \n \nLogin ID: $row->username \n Please login here with this new password: \n\n

\n\n
$key
$site_url
\n\n

 \n\n Thank You \n \n Site Administrator", "$headers")) {
        echo "<p><b>Success</b></p> <br><p>Your password is sent to your email address. <a href='quizhome.php'>Login</a> with your new password here.</p> ";
    } else {
        echo "Error sending email. <br><br><input type='button' value='Retry' onClick='history.go(-1)'>";
    } // end email code
     
    // now encrypt password for database
    $salt = $row->salt;
    $key = hash('sha512', $key . $salt);
    $sql = $dbo->prepare("UPDATE members SET password ='$key' WHERE email='$em'");
    $sql->execute();
}
 // end if


else {
    echo "<p>$msg <br><br><input type='button' value='Retry' onClick='history.go(-1)'></p>";
}
?>
        </div>
        </div>
</body>

</html>
