<?php

function list_title($list) {
	return get_list_title($list);
}

function get_list_title($list) {
	$contents = file_get_contents($list);
	$lines = explode(PHP_EOL, $contents);
	$last_line = parse_line($lines[count($lines) - 2]);

	
	return str_replace('titel:', '', $last_line['roms']);
}