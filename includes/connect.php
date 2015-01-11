<?php
include_once 'config.inc.php'; 
$mysqli = new mysqli(HOST, USER, PASSWORD, DATABASE);
$dbo = new PDO('mysql:host=localhost;dbname='.DATABASE, USER, PASSWORD);
$username = "";
$password = "";
$database = "slcquiz";
mysql_connect(localhost, $username, $password);
@mysql_select_db($database) or die("Unable to select database");
?>