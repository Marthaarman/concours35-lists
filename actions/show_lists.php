<?php

add_action('html_head', 'show_lists_css');

function show_lists_css() {
	echo "<link rel='stylesheet' type='text/css' href='assets/show_lists.css' />";
}

add_action('show_lists', 'show_lists_func');

function show_lists_func($filter = false) {
	//	check what lists to show
	//	create a filter for glob function
	$search_query = "";
	switch($filter) {
		case 'starts':
			$search_query = "concours startlijst rooster *.dat";
			break;
		case 'results':
			$search_query = "concours uitslag rooster *.dat";
			break;
		case 'none':
		default:
			$search_query = "concours *.dat";
			break;
	}
	
	echo "<div class='lists'>";
	
	// obtain all files with this search query
	$files = glob("files/{$search_query}");
	foreach($files as $file) {
		make_list_button($file);
	}
	
	echo "</div>";
}

function make_list_button($file) {
	//	set basic variables for the given button
	//	variable name represents its function
	$contents = file_get_contents($file);
	$lines = explode(PHP_EOL, $contents);
	$title = str_replace('titel:', '', $lines[1]);
	
	$type = strpos($file,'startlijst') !== false ? 'startlijst' : 'uitslag';
	switch($type) {
		case 'startlijst':
			$button_title = "[startlijst] {$title}";
			$button_link = "index.php?type=show_starts&file=".base64_encode($file);
			break;
		case 'uitslag':
			$button_title = "[uitslag] {$title}";
			$button_link = "index.php?type=show_results&file=".base64_encode($file);
			break;
	}
	
	$qr_link = "index.php?type=qr&link=".base64_encode($button_link);
	
	echo "
		<div class='list_button'>
			<a href='{$button_link}'>
				<div class='title'>{$button_title}</div>
			</a>
			<a href='{$qr_link}'>
				<div class='qr'>QR</div>
			</a>
			<a href='{$qr_link}'>
				<div class='qr'>link</div>
			</a>
		</div>
	";
}

