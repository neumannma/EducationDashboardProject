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
		die("connection failed: " . $connection->connect_error);

	// send SQL query and receive result
	$sql = "SHOW TABLES";
	$result = $connection->query($sql);

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
					</select>
				</div>
				<div class="list">
					<p class="label">Gender</p>
					<select id="list-gender">
						<option value=""> - </option>
						<option value="male">Male</option>
						<option value="female">Female</option>
					</select>
				</div>
				<div class="list">
					<p class="label">Filter</p>
					<select id="list-filter">
						<option value=""> - </option>
						<option value="exclude-absent">Exclude Absentees</option>
					</select>
				</div>
				<button onClick="load()">Submit</button>
			</div>	<!-- input -->
		</div>	<!-- wrapper -->
	</body>
</html>
