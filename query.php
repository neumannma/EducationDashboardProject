<?php
	$servername = "localhost";
	$username = "remote";
	$password = "password";
	$dbname = "data";

	// get table name from URL
	$tablename = $_REQUEST["table"];
	
	// create connection to database
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	// check connection
	if ($connection->connect_error)
		die("connection failed: " . $connection->connect_error);
	
	// send SQL query
	$sql = "SELECT * FROM " . $tablename;
	$result = $connection->query($sql);
	
	// format results as associative array
	$data = array();
	while ($row = $result->fetch_assoc())
		$data[] = $row;
	
	// print data as JSON
	$json = json_encode($data);
	echo $json;
	
?>
