<?php
	require 'amartinSQL.php';

	// fetch settings from INI file
	$config = parse_ini_file("resources/config.ini");
	$hostname = $config["hostname"];	// database credentials
	$username = $config["username"];	// database credentials
	$password = $config["password"];	// database credentials
	$database = $config["database"];	// map data source
	$logdb 	  = $config["logdb"];		// user activity log database
	$logtable = $config["logtable"];	// user activity log table

	// dictionary containing possible database selection clauses
	$dict_select = array();
	$dict_select["pass"] 	= "100 * COUNT( CASE WHEN (division = 'I' OR division = 'DISTINCTION' OR division = 'II' OR division = 'MERIT' OR division = 'III' OR division = 'CREDIT' OR division = 'IV' OR division = 'PASS') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["top3div"] = "100 * COUNT( CASE WHEN (division = 'I' OR division = 'DISTINCTION' OR division = 'II' OR division = 'MERIT' OR division = 'III' OR division = 'CREDIT') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["div1"] 	= "100 * COUNT( CASE WHEN (division = 'I' OR division = 'DISTINCTION') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["div2"] 	= "100 * COUNT( CASE WHEN (division = 'II' OR division = 'MERIT') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["div3"] 	= "100 * COUNT( CASE WHEN (division = 'III' OR division = 'CREDIT') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["div4"] 	= "100 * COUNT( CASE WHEN (division = 'IV' OR division = 'PASS') THEN 1 END ) / COUNT(*) AS 'value'";
	$dict_select["fail"] 	= "100 * COUNT( CASE WHEN (division = '0' OR division = 'FLD' OR division = 'FAIL') THEN 1 END ) / COUNT(*) AS 'value'";

	// dictionary containing possible database where (filtering) clauses
	$dict_where = array();
	$dict_where["male"] 			= "gender = 'M'";
	$dict_where["female"] 			= "gender = 'F'";
	$dict_where["public"] 			= "ownership = 'PUBLIC'";
	$dict_where["private"] 			= "ownership = 'PRIVATE'";
	$dict_where["unknown"] 			= "ownership IS NULL OR ownership=''";
	$dict_where["exclude-absent"] 	= "division = 'I' OR division = 'DISTINCTION' OR division = 'II' OR division = 'MERIT' OR division = 'III' OR division = 'CREDIT' OR division = 'IV' OR division = 'PASS' OR (division = '0' OR division = 'FLD' OR division = 'FAIL')";
	
	// create connection to database
	$connection = new mysqli($hostname, $username, $password, $database);
	
	// check connection
	if ($connection->connect_error)
	{
		error_log(__FILE__ . ": ERROR CONNECTING TO DATABASE");
		exit(1);
	}
	
	// send SQL query for map data
	$query = new amartinSQL();
	$query->select( array("`hc-key`", $dict_select[$_REQUEST["data"]]) );
	$query->from( array( amartinSQL::escape($_REQUEST["year"]) ) );
	if ( isset($dict_where[$_REQUEST["gender"]]) )
		$query->where( array($dict_where[$_REQUEST["gender"]]) );
	if ( isset($dict_where[$_REQUEST["ownership"]]) )
		$query->where( array($dict_where[$_REQUEST["ownership"]]) );
	if ( isset($dict_where[$_REQUEST["filter"]]) )
		$query->where( array($dict_where[$_REQUEST["filter"]]) );
	$query->group_by( array("`hc-key`") );
	$result = $connection->query($query->getQuery());

	// check result
	if ($result === FALSE)
	{
		error_log(__FILE__ . ": BAD QUERY: \"" . $query->getQuery() . "\" on line " . __LINE__);
		exit(1);
	}

	// format result as associative array
	$data = array();
	while ($row = $result->fetch_assoc())
		$data[] = $row;

	// calculate min and max
	$rangequery =
	"
		SELECT
			MIN( value ) as 'min',
			MAX( value ) as 'max'
		FROM (" . $query->getQuery() . ") count;
	";
	$result = $connection->query($rangequery);
	if ($result === FALSE)
	{
		error_log(__FILE__ . ": BAD QUERY: \"" . $rangequery . "\" on line " . __LINE__);
		exit(1);
	}
	$result = $result->fetch_assoc();
	$min = $result["min"];
	$max = $result["max"];
	
	/*
	// calculate a single min/max for the year, regardless of other filters
	$rangequery =
	"
		SELECT
			MIN( value ) as 'min',
			MAX( value ) as 'max'
		FROM
		(
			SELECT " . $dict_select[$_REQUEST["data"]] . "
			FROM " . amartinSQL::escape($_REQUEST["year"]) . "
			GROUP BY `hc-key`
		) count;
	";
	$result = $connection->query($rangequery);
	if ($result === FALSE)
	{
		error_log(__FILE__ . ": BAD QUERY: \"" . $rangequery . "\" on line " . __LINE__);
		exit(1);
	}
	$result = $result->fetch_assoc();
	$min = $result["min"];
	$max = $result["max"];
	*/
	
	// create object
	$pre_json = array
	(
		"min" => $min,
		"max" => $max,
		"data" => $data
	);

	// log user activity
	$connection->close();
	if ($_REQUEST["make_log_entry"] === "true")
	{
		$connection = new mysqli($hostname, $username, $password, $logdb);
		$logquery = "INSERT INTO " . $logtable . " (year, data, gender, ownership, filter) VALUES (\"" . $_REQUEST["year"] . "\", \"" . $_REQUEST["data"] . "\", \"" . $_REQUEST["gender"] . "\", \"" . $_REQUEST["ownership"] . "\", \"" . $_REQUEST["filter"] . "\")";
		$connection->query($logquery);
		$connection->close();
	}

	/*	ONLY WORKS FOR PHP 5.0+ (alternate log user activity)
	if ($_REQUEST["make_log_entry"] === "true")
	{
		$connection = new mysqli($hostname, $username, $password, $logdb);
		$logquery = $connection->prepare("INSERT INTO " . $logtable . " (year, data, gender, ownership, filter) VALUES (?, ?, ?, ?, ?)");
		$logquery->bind_param("issss", $_REQUEST["year"], $_REQUEST["data"], $_REQUEST["gender"], $_REQUEST["ownership"], $_REQUEST["filter"]);
		$logquery->execute();
		$logquery->close();
		$connection->close();
	}
	*/
	
	// print data as JSON
	$json = json_encode($pre_json);
	echo $json;
?>