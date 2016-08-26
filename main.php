<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		
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
						$servername = "localhost";
						$username = "remote";
						$password = "password";
						$dbname = "map";

						// connect to database
						$connection = new mysqli($servername, $username, $password, $dbname);

						// check connection
						if ($connection->connect_error)
							die("connection failed: " . $connection->connect_error);
	
						// send SQL query
						$sql = "SHOW TABLES";
						$result = $connection->query($sql);

						// format results as array of strings
						$data = array();
						while ($row = $result->fetch_assoc())
							$data[] = $row["Tables_in_" . $dbname];
	
						foreach ($data as $value)
							echo "<option value=\"query.php/?table=" . $value ."\">" . $value . "</option>\n";
					?>
				</select>
			</div>
		</div>
	</body>
</html>
