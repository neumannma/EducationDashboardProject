#!/bin/php
<?php
	function append_json($path, $file, $outfile)
	{
		$json = file_get_contents($path . $file);	// read JSON file into string
		$data = json_decode($json, true);			// convert to PHP assoc array
		if (array_key_exists(0, $data))
		{
			foreach ($data as $obj)						// check if there is more than one object in the file
			{
				$obj["center_id"] = substr($file, 0, -5);	// add field for school id
				$json = json_encode($obj);					// convert object to json string
				fwrite($outfile, $json . ',');				// write string and trailing comma to file
			}
		}
		else
		{
			$data["center_id"] = substr($file, 0, -5);
			$json = json_encode($data);
			fwrite($outfile, $json . ',');
		}
	}

	function write_file($path, $filename)
	{
		$dir = scandir($path);								// create an array of all filenames in directory
		if (file_exists($filename))
			unlink($filename);								// remove file if it already exists prior to writing
		$outfile = fopen($filename, 'a');

		fwrite($outfile, "[");
		foreach ($dir as $value)
			if ( filesize($path . $value) )	// only execute on public schools with nonempty entries
				append_json($path, $value, $outfile);
		ftruncate($outfile, fstat($outfile)["size"] - 1);
		fwrite($outfile, "]");

		fclose($outfile);
	}

	$path = "./CSEE/";
	$dir = scandir($path);
	foreach ($dir as $year)
		if ($year != "." and $year != "..")
			write_file($path . $year . '/', $year . ".json");
?>