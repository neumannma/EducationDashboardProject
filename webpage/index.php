<!DOCTYPE html>
<?php
	// fetch configuration settings
	$config = parse_ini_file("resources/config.ini");
	$hostname = $config["hostname"];
	$username = $config["username"];
	$password = $config["password"];
	$database = $config["database"];

	// connect to database
	$connection = new mysqli($hostname, $username, $password, $database);

	// check connection
	if ($connection->connect_error)
	{
		error_log(__FILE__ . ": ERROR CONNECTING TO DATABASE");
		exit(1);
	}

	// send SQL query and receive result
	$query_string = "SHOW TABLES";
	$result = $connection->query($query_string);

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
?>
<html>
	<head>
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- import CSS -->
		<link rel="stylesheet" type="text/css" href="style.css">

		<!-- import jQuery -->
		<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

		<!-- import HighMaps -->
		<script defer src="http://code.highcharts.com/maps/highmaps.js"></script>
		<script defer src="http://code.highcharts.com/maps/modules/exporting.js"></script>
		<script defer src="http://code.highcharts.com/mapdata/countries/tz/tz-all.js"></script>

		<!-- import my scripts -->
		<script defer src="client.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<div id="map"></div>
			<div id="input">
				<div class="list">
					<p class="label">Year</p>
					<select id="list-year">
						<?php
							foreach ($data as $value)
								echo "<option value=\"" . $value ."\">" . $value . "</option>\n";
						?>
					</select>
				</div>
				<div class="list">
					<p class="label">Data</p>
					<select id="list-data">
						<option value="pass">Pass Rate</option>
						<option value="top3div">Top 3 Divisions Rate</option>
						<option value="div1">Division 1 Rate</option>
						<option value="div2">Division 2 Rate</option>
						<option value="div3">Division 3 Rate</option>
						<option value="div4">Division 4 Rate</option>
						<option value="fail">Fail Rate</option>
					</select>
				</div>
				<div class="list" id="div-gender">
					<p class="label">Gender</p>
					<select id="list-gender" onChange="link_inputs()">
						<option value="all">All</option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
					<div class="radio" id="radio-gender" onChange="link_inputs()">
						<input type="radio" name="gender" value="all" checked>All
						<input type="radio" name="gender" value="male">Male
						<input type="radio" name="gender" value="female">Female
					</div>
				</div>
				<div class="list" id="div-ownership">
					<p class="label">Ownership</p>
					<select id="list-ownership">
						<option value="all">All</option>
						<option value="public">Public</option>
						<option value="private">Private</option>
					</select>
					<div class="radio" id="radio-ownership" onChange="link_inputs()">
						<input type="radio" name="ownership" value="all" checked>All
						<input type="radio" name="ownership" value="public">Public
						<input type="radio" name="ownership" value="private">Private
					</div>
				</div>
				<div class="list" id="div-filter">
					<p class="label">Candidates</p>
					<select id="list-filter">
						<option value="none">Registered</option>
						<option value="exclude-absent">Clean</option>
					</select>
					<div class="radio" id="radio-filter" onChange="link_inputs()">
						<input type="radio" name="filter" value="none" checked>Registered
						<input type="radio" name="filter" value="exclude-absent">Clean
					</div>
				</div>
				<button onClick="load()">Submit</button>
			</div>	<!-- input -->
		</div>	<!-- wrapper -->
	</body>
</html>
