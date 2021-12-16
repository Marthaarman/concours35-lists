<?php 

//	add hook to header only when results are needed
add_action('html_head_results', 'results_css');
add_action('html_head_show_results', 'results_css');

//	the hook's function that adds results css to the header
function results_css() {
	echo "<link rel='stylesheet' type='text/css' href='assets/results.css' />";
}


//	hook to the result list filter
add_action('show_result_files', 'show_result_lists_func');

//	result list filter, show all result lists
//	also show the title of the page
function show_result_lists_func() {
	back_button();
	show_result_lists_title();
	do_action('show_lists', 'results');
}

//	function for result lists title
function show_result_lists_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']}</div>";
}


///////////////////////////////////////////////////////////////////////////////

//	add hook to show the results of a specific list
add_action('show_results', 'show_results_func');

//	set the content for showing a specific resulting list
//	set the title of the page
function show_results_func() {
	global $SETTINGS;
	back_button();
	show_result_list_title();
	do_action('show_list', array($_GET['list'], $SETTINGS['results_columns']));
}

function show_result_list_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']} - Uitslag: ".get_list_title(base64_decode($_GET['list']))."</div>";
}
