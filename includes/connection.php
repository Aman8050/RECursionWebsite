<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "cslab";
	$connection = mysqli_connect($host, $user, $pass, $db);
	
	if (!$connection) {
	
		die ("Error connecting");
		
	}
	else {
	}
?>