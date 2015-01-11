<?php
/**
 * registration webpage
 */
include_once 'includes/register.inc.php';
include_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Student Leadership Competencies: Registration Form</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css"/> <!-- Actual used stylesheet -->
    </head>
    <p>
        <img src="includes/SLC Inventory.png" alt="SLC Inventory" width="800px">
    </p>
    <body>
	<div id="content">
	<div id="os_content">

        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Register with us</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        
        <style type="text/css">
            
            table, tr, td{
                border: 0px solid gray;
            }    
            
            button, input[type="button"], input[type="submit"] { 
                background-color:#0B5A93; 
                color:white;
            } 
            
        </style>
        
        <ul>
            <li>Usernames may contain only digits, upper and lower case letters and underscores.</li>
            <li>Emails must have a valid email format.</li>
            <li>Passwords must be at least 6 characters long.</li>
            <li>Passwords must contain:
                <ul>
                    <br />
                    <li>At least one upper case letter (A..Z)</li>
                    <li>At least one lower case letter (a..z)</li>
                    <li>At least one number (0..9)</li>
                </ul>
            </li>
            <li>Your password and confirmation must match exactly.</li>
	    <li>Please include your institution (University, etc) and your full name.</li>
        </ul>
        <br />
        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>" >
            <table width="30%" align="center">
                <tr>
                    <td>Username:</td><td> <input type='text' name='username' id='username' /></td>
                </tr>
                <tr>
                    <td>Email: </td><td> <input type="text" name="email" id="email" /></td>
                </tr>
                <tr>
                    <td>Password: </td><td> <input type="password"
                             name="password" 
                             id="password"/></td>
                </tr>
                <tr>
                    <td>Confirm password: </td><td> <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /></td>
                </tr>
                <tr>
                    <td>Institution:</td><td> <input type='text' name='institution' id='institution' /></td>
                </tr>
                <tr>
                    <td>Full Name:</td><td> <input type='text' name='fullname' id='fullname' /></td>
                </tr>
                <tr>
                    <td colspan="2"><p><input type="button" 
                           value="Create Account" 
                           onclick="return regformhash(this.form,
                                           this.form.username,
                                           this.form.email,
                                           this.form.password,
                                           this.form.confirmpwd
                                        );" /> </p></td>
                <!-- notice how I don't hash institution and fullname -->
		</tr>
            </table>
        </form>
        <br />
        <p>Return to the <a href="quizhome.php">login page</a>.</p>
		</div>
		</div>
    </body>
</html>
