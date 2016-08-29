<!DOCTYPE html>
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
			<div id="map-div"></div>
			<div id="list-div">
				<select id="list" name="data" onChange="reload()">
					<?php
						// fetch settings from INI file
						$ini = parse_ini_file("server.ini");
						$hostname = $ini["hostname"];
						$username = $ini["username"];
						$password = $ini["password"];
						$database = $ini["database"];

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
						
						// output HTML
						foreach ($data as $value)
							echo "<option value=\"query.php/?table=" . $value ."\">" . $value . "</option>\n";
					?>
				</select>
			</div>
		</div>
	</body>
</html>
