<?php

function get_list_title($list) {
	$contents = file_get_contents($list);
	$lines = explode(PHP_EOL, $contents);
	return str_replace('titel:', '', $lines[1]);
}