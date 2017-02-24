<?php
	// fetch MySQLi connnection configuration settings
	$config = parse_ini_file("resources/config.ini");
	$hostname = $config["hostname"];
	$username = $config["username"];
	$password = $config["password"];
	$database = $config["database"];

	// connect to database
	$connection = new mysqli($hostname, $username, $password, $database);

	// verify connection
	if ($connection->connect_error)
	{
		error_log(__FILE__ . ": ERROR CONNECTING TO DATABASE");
		exit(1);
	}

    // query list of years (via table names)
	$sql = "SHOW TABLES";
	$result = $connection->query($sql);

	// check that query executed successfully
	if ($result === FALSE)
	{
		error_log(__FILE__ . ": BAD QUERY: \"" . $query_string . "\" on line " . __LINE__);
		exit(1);
	}

	// format results as array of strings
	$data = array();
	while ($row = $result->fetch_assoc())
		$data[] = $row["Tables_in_" . $database];

	// reverse array to list years in descending order
	$data = array_reverse($data);

    // print years as JSON
    $json = json_encode($data);
    echo $json;
?>