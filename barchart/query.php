<?php
    // fetch settings from INI file
	$config = parse_ini_file("resources/config.ini");
	$hostname = $config["hostname"];	// database credentials
	$username = $config["username"];	// database credentials
	$password = $config["password"];	// database credentials
	$database = $config["database"];	// map data source
	$logdb 	  = $config["logdb"];		// user activity log database
	$logtable = $config["logtable"];	// user activity log table

    // parse arguments from HTTP request
	$necta = $_REQUEST["necta"];		// ID of the school
    $gender = in_array($_REQUEST["gender"], array("M", "F", "m", "f")) ? $_REQUEST["gender"] : NULL;		// one of: M, F (else null)
	$year_start = $_REQUEST["start"];	// earliest year to display data from
	$year_end = $_REQUEST["end"];		// latest year " "

    // create connection to database
	$connection = new mysqli($hostname, $username, $password, $database);

	// check connection
	if ($connection->connect_error) {
		error_log(__FILE__ . ": ERROR CONNECTING TO DATABASE");
		exit(1);
	}

	$data = array();
	foreach (range($year_start, $year_end) as $year) {
		// construct query
		$str = sprintf("SELECT division, COUNT(*) AS 'value' FROM `%s` WHERE necta = '%s' ", $year, $necta);
		if (isset($gender))
			$str .= sprintf("AND gender = '%s' ", $gender);
		$str .= "GROUP BY division;";

		// execute query
		error_log($str);
		$result = $connection->query($str);

		// check result
		if ($result === FALSE) {
			error_log(__FILE__ . ": BAD QUERY: \"" . $query->getQuery() . "\" on line " . __LINE__);
			exit(1);
		}

		for ($set = array(); $row = $result->fetch_assoc(); $set[] = $row);
		$data[$year] = $set;
	}
	echo json_encode($data, JSON_PRETTY_PRINT);
?>
