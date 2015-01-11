<?php

/*
 *  parses login data. 
 */

include_once 'connect.php';
include_once 'functions.php';

sec_session_start(); // Our custom secure way of starting a PHP session.

if (isset($_POST['email'], $_POST['p'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['p']; // The hashed password. // Kite: not hashed anymore
    
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        if (get_username_via_email($email) == "admin" || 
                get_username_via_email($email) == "kiteadmin"){ // REDIRECTS TO admin.php if admin
            header("Location: ../admin.php");
            exit();
        }
        header("Location: ../quiz.php"); // REDIRECTS TO quiz.php if logged in
        exit();
    } else {
        // Login failed 
        header('Location: ../quizhome.php?error=1'); // REDIRECTS TO quizhome.php if not logged in
        exit();
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../error.php?err=Could not process login');
    exit();
}