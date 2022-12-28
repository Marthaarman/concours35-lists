<?php

add_action('show_list', 'show_list_func');

function show_list_func($args) {
	global $SETTINGS;
	//	load the functions arguments into variables
	$list = base64_decode($args[0]);
	
	//	all the allowed columns will be put in here by their index as value
	$allowed_columns = array();
	
	//	get the content of the data file
	//	make an array of all the lines from the data file
	$contents = file_get_contents($list);
	foreach($SETTINGS['starts_columns'] as $column_key => $column_item) {
		if(strpos($contents, $column_key.':') > 0) {
			$allowed_columns[$column_key] = $column_item;
		}
	}

	$lines = explode(PHP_EOL, $contents);

	$rider_rows = [];
	$rider_row = [];
	$i = 0;
	foreach($lines as $line_number => $line_content) {
		$parsed_line = parse_lines($line_number, $lines);
		if(!$parsed_line) {
			if(count($rider_row) > 0) {
				$i++;
				$rider_row = array_merge(array('nr' => $i), $rider_row);
				$rider_rows[] = $rider_row;
				$rider_row = [];
			}
		}else {
			$rider_row = $parsed_line;
		}
	}
	
	//	output the content
	echo "
		<div id='list'>
			<table>
				".list_table_thead($rider_rows, $allowed_columns)."
				".list_table_rows($rider_rows, $allowed_columns)."
			</table>
		</div>
	";
	
}

//	this function returns the table header with the allowed columns
//	it returns the table header in printable format
function list_table_thead($rider_rows, $allowed_columns) {
	if(count($rider_rows) > 0) {
		$return = "<thead>";
		foreach($allowed_columns as $column_key => $column_title) {
			$return .= "<td>{$column_title}</td>";
		}
		$return .= "</thead>";
		return $return;
	}
	return "";
	
}

//	this function returns each row's allowed columns in the right order
//	it returns the values in printable format
function list_table_rows($rider_rows, $allowed_columns) {
	global $SETTINGS;
	$return = "";
	foreach($rider_rows as $rider_row) {
		$return .= "<tr>";
		foreach($allowed_columns as $row_key => $row_value) {
			if(isset($rider_row[$row_key])) {
				$return .= "<td>{$rider_row[$row_key]}</td>";
			}else {
				$return .= "<td></td>";
			}
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

function parse_line($line) {
	$delimiter = '	';
	$array = array();
	$line_components = explode($delimiter, $line);
	foreach($line_components as $line_component) {
		$key_value = explode(':', $line_component);
		if(count($key_value) == 2) {
			$array[$key_value[0]] = $key_value[1];
		}
	}

	return $array;
}

function parse_lines($line_number, $lines) {
	$parsed_lines = [];

	$parsed_line = parse_line($lines[$line_number]);
	if(isset($parsed_line['status']) && !isset($parsed_line['roms'])) {
		$parsed_lines = array_merge($parsed_lines, $parsed_line);
		$line_number++;
	}else {
		return false;
	}

	while(true) {
		$parsed_line = parse_line($lines[$line_number]);
		if(!isset($parsed_line['status'])) {
			$parsed_lines = array_merge($parsed_lines, $parsed_line);
			$line_number++;
		}else {
			break;
		}
		if(!isset($lines[$line_number])) {
			break;
		}
	}
	return $parsed_lines;
}

function print_pre($array) {
	echo '<pre>';
	print_r($array);
	echo '</pre>';
}