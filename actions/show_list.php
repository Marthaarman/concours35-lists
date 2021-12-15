<?php

add_action('show_list', 'show_list_func');

function show_list_func($args) {
	//	load the functions arguments into variables
	$list = base64_decode($args[0]);
	$columns = $args[1];
	
	//	all the allowed columns will be put in here by their index as value
	$allowed_columns = array();
	
	//	get the content of the data file
	//	make an array of all the lines from the data file
	$contents = file_get_contents($list);
	$lines = explode(PHP_EOL, $contents);
	
	$line0 = 3;				//	initial line with data
	$rij_b = false;			//	two rows of data or one row
	$line_increment = 1;	//	for two rows, this will be set to 2
	
	//	check if rij_b
	if(explode(':', $lines[$line0 + 1])[0] == 'rij_b') {
		$rij_b = true;
		$line_increment = 2;
	}
	
	//	set columns
	//	the given columns are set in the first 'rij' elements of the file
	//	if rij_b then combine two lines, else only take first line
	$full_line = $rij_b ? $lines[$line0].'	'.$lines[$line0 + 1] : $lines[$line0];
	$line_array = arrayfy_list($full_line);
	

	//	for each column found in the settings, see if they are found in the file
	//	if found, attach the place the index of the file's column in the allowed columns by the title of the file's column
	foreach($columns as $file_column_title => $new_column_title) {
		if(in_array($new_column_title, $line_array)) {
			$allowed_columns[$file_column_title] = array_search($new_column_title, $line_array);
		}
	}
	
	
	//	start processing each line
	//	add all valid lines to the list_values array
	$list_values = array();
	$final_line = count($lines);
	for($linenr = $line0 + $line_increment; $linenr <= $final_line; $linenr += $line_increment) {
		// 	if row indicator equals 'rij_s', increase line nr with 1
		if(explode(':', $lines[$linenr])[0] == 'rij_s') {
			$linenr++;
		}
		//	make sure it is a valid line
		//	if not, file has ended most likely
		if(explode(':', $lines[$linenr])[0] == 'rij') {
			$full_line = $rij_b ? $lines[$linenr].'	'.$lines[$linenr + 1] : $lines[$linenr];
			$line_array = arrayfy_list($full_line);
			//	make sure the line starts with a nr
			// 	if not, not a valid starting position
			if(is_numeric($line_array[0])) {
				$list_values[] = $line_array;
			}
		}else {
			break;
		}
	}
	
	//	output the content
	echo "
		<div id='list'>
			<table>
				".list_table_thead($allowed_columns, $columns)."
				".list_table_rows($list_values, $allowed_columns)."
			</table>
		</div>
	";
	
}

//	this function returns the table header with the allowed columns
//	it returns the table header in printable format
function list_table_thead($allowed_columns, $settings_columns) {
	$return = "<thead>";
	foreach($allowed_columns as $file_column_title => $file_column_index) {
		$return .= "<td>{$settings_columns[$file_column_title]}</td>";
	}
	$return .= "</thead>";
	return $return;
}

//	this function returns each row's allowed columns in the right order
//	it returns the values in printable format
function list_table_rows($list_values, $allowed_columns) {
	$return = "";
	foreach($list_values as $list_value) {
		$return .= "<tr>";
		foreach($allowed_columns as $file_column_index) {
			$return .= "<td>{$list_value[$file_column_index]}</td>";
		}
		$return .= "</tr>";
	}
	return $return;
}

//	The arryfy_list function gets a string (one or two lines) from the data file
//	it makes sure all the columns are correctly seperated
//	then it makes an array out of each column and returns the array
//	it removes the row 'rij:'/'rij_b:' indicator from the string as well
function arrayfy_list($string) {
	//	remove the row indicators
	$string = str_replace(array('rij:', 'rij_b:'), "", $string);
	
	//	how to divide the string into columns, what are the delimiters?
	$delimiters = array(
		"--",
		"	"
	);
	//	place a general spacer for the final explode function
	$spacer = "----";
	$string = str_replace($delimiters, $spacer, $string);
	
	//	explode the string and return as array
	return explode($spacer, $string);
}