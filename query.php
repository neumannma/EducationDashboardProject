<?php
	$servername = "localhost";
	$username = "remote";
	$password = "password";
	$dbname = "map";

	// get table name from URL
	$tablename = $_REQUEST["table"];
	
	// create connection to database
	$connection = new mysqli($servername, $username, $password, $dbname);
	
	// check connection
	if ($connection->connect_error)
		die("connection failed: " . $connection->connect_error);
	
	// send SQL query
	$sql = "SELECT * FROM `" . $tablename . "`";
	$result = $connection->query($sql);
	
	// format result as associative array
	$data = array();
	while ($row = $result->fetch_assoc())
		$data[] = $row;
	
	// calculate min and max
	$min = INF;
	$max = 0;
	foreach ($data as $value)
	{
		$max = $max > $value["value"] ? $max : $value["value"];
		$min = $min < $value["value"] ? $min : $value["value"];
	}
	
	// create object with 
	$pre_json = array
	(
		"min" => $min,
		"max" => $max,
		"data" => $data
	);
	
	// print data as JSON
	$json = json_encode($pre_json, JSON_PRETTY_PRINT);
	echo $json;
?>
