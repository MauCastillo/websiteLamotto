<?php
	/* Database connection start */
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "motto_website";

	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
	try {
	  $mysqli = new mysqli($servername, $username, $password,$dbname);
	  $mysqli->set_charset("utf8mb4");
	} catch(Exception $e) {
	  error_log($e->getMessage());
	  exit('Error connecting to database'); 
	}
?>