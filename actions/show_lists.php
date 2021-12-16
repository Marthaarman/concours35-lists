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
	
	echo "<div id='lists'>";
	
	// obtain all files with this search query
	$lists = glob("files/{$search_query}");
	sort($lists);
	foreach($lists as $list) {
		make_list_button($list);
	}
	
	echo "</div>";
}

function make_list_button($list) {
	//	set basic variables for the given button
	//	variable name represents its function
	$title = get_list_title($list);
	$return_type = isset($_GET['type']) ? $_GET['type'] : 'default';
	$type = strpos($list,'startlijst') !== false ? 'startlijst' : 'uitslag';
	switch($type) {
		case 'startlijst':
			$button_title = "[startlijst] {$title}";
			$button_link = "index.php?type=show_starts&return_type={$return_type}&list=".base64_encode($list);
			break;
		case 'uitslag':
			$button_title = "[uitslag] {$title}";
			$button_link = "index.php?type=show_results&return_type={$return_type}&list=".base64_encode($list);
			break;
	}
	
	$qr_link = "index.php?type=qr&return_type={$return_type}&list={$list}&link=".base64_encode($button_link);
	
	echo "
		<div class='list_button'>
			<a href='{$button_link}'>
				<div class='list_button_title button'>{$button_title}</div>
			</a>
			<a href='{$qr_link}'>
				<div class='list_button_qr button'>QR</div>
			</a>
			<a href='{$qr_link}'>
				<div class='list_button_qr button'>link</div>
			</a>
		</div>
	";
}

