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

	// reverse results array
	$data = array_reverse($data);
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
					<div class="radio" id="radio-gender">
						<input type="radio" name="gender" id="gender1" value="all" onChange="link_inputs()" checked>
						<label for="gender1">
							<div class="button">All</div>
						</label>
						<input type="radio" name="gender" id="gender2" onChange="link_inputs()" value="male">
						<label for="gender2">
							<div class="button">Male</div>
						</label>
						<input type="radio" name="gender" id="gender3" onChange="link_inputs()" value="female">
						<label for="gender3">
							<div class="button">Female</div>
						</label>
					</div>
				</div>
				<div class="list" id="div-ownership" onChange="link_inputs()">
					<p class="label">Ownership</p>
					<select id="list-ownership">
						<option value="all">All</option>
						<option value="public">Public</option>
						<option value="private">Private</option>
						<option value="unknown">Unknown</option>
					</select>
					<div class="radio" id="radio-ownership">
						<input type="radio" name="ownership" id="ownership-all" onChange="link_inputs()" value="all" checked>
						<label for="ownership-all">
							<div class="button">All</div>
						</label>
						<input type="radio" name="ownership" id="ownership-public" onChange="link_inputs()" value="public">
						<label for="ownership-public">
							<div class="button">Public</div>
						</label>
						<input type="radio" name="ownership" id="ownership-private" onChange="link_inputs()" value="private">
						<label for="ownership-private">
							<div class="button">Private</div>
						</label>
						<input type="radio" name="ownership" id="ownership-unknown" onChange="link_inputs()" value="unknown">
						<label for="ownership-unknown">
							<div class="button">Unknown</div>
						</label>
					</div>
				</div>
				<div class="list" id="div-filter" onChange="link_inputs()">
					<p class="label">Candidates</p>
					<select id="list-filter">
						<option value="none">Registered</option>
						<option value="exclude-absent">Clean</option>
					</select>
					<div class="radio" id="radio-filter">
						<input type="radio" name="filter" id="filter-none" onChange="link_inputs()" value="none" checked>
						<label for="filter-none">
							<div class="button">Registered</div>
						</label>
						<input type="radio" name="filter" id="filter-exclude-absent" onChange="link_inputs()" value="exclude-absent">
						<label for="filter-exclude-absent">
							<div class="button">Clean</div>
						</label>
					</div>
				</div>
				<button onClick="load()">Submit</button>
				<p class="link">Brought to you by<br><a href="http://www.tetea.org/">TETEA Inc.</a></p>
			</div>	<!-- input -->
		</div>	<!-- wrapper -->
	</body>
</html>