<?php

/*
 * Protected page to update password
 */

include_once 'includes/connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies: Change Password</title>
		
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
                <h1>Change Password</h1>
                
            <?php
            function updatePassword(){
                $dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
                $username = $_SESSION['username'];
                $count = $dbo->prepare("SELECT email,username,salt FROM members WHERE username = '$username'");
                $count->execute();
                $row = $count->fetch(PDO::FETCH_OBJ);

                $salt = $row->salt;
                $newpass = hash('sha512', $_POST['password'] . $salt);
                $sql = $dbo->prepare("UPDATE members SET password ='$newpass' WHERE username='$username'");
                $sql->execute();
            }
            
            if ( (isset($_POST['password'])) && (isset($_POST['confirm'])) ){
                if ($_POST['password'] == $_POST['confirm']){
                    updatePassword();
                    echo '<p>Password successfully changed. </p>';
                }else{
                    echo '<p>Your password and confirmation does not match.</p>';
                }  
            }else{
                if (empty($_POST)){
                    echo '';
                }else{
                    echo '<p>You have missing fields.</p>';
                }
            }
            
            ?>
                <ul>
                    <li>Enter your new password and confirmation. Changes will take effect immediately.</li>
                    <li>Passwords must be at least 6 characters long.</li>
                    <li>Passwords must contain:
                        <ul>
                            <br />
                            <li>At least one upper case letter (A..Z)</li>
                            <li>At least one lower case letter (a..z)</li>
                            <li>At least one number (0..9)</li>
                        </ul>
                    </li>
                </ul>
                <br />
                <form method="post" name="changepass" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" >
                    New password: <input type="text" name="password" id="password">
                    Confirm new password: <input type="text" name="confirm" id="confirm">
                    <input type="submit" name="submit" value="Change Password">
                    <br />
                </form>
                <br />

<?php

?>

            </p>
            <p>Return to <a href="quizhome.php">Dashboard</a></p>
            
            
            <?php else: ?>
                <br />
		<br />
                <span class="error">You must be logged in to change your password.</span> Please <a href="quizhome.php">login</a>.
		<br />
                </p>
            <?php
            endif;
            ?>
            </div>
        </div>
    </body>
</html>

