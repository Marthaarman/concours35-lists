<?php 

//	add hook to header only when starts are needed
add_action('html_head_starts', 'starts_css');
add_action('html_head_show_starts', 'starts_css');

//	the hook's function that adds starts css to the header
function starts_css() {
	echo "<link rel='stylesheet' type='text/css' href='assets/starts.css' />";
}


//	hook to the start list filter
add_action('show_start_files', 'show_start_lists_func');

//	start list filter, show all start lists
//	also show the title of the page
function show_start_lists_func() {
	back_button();
	show_start_lists_title();
	do_action('show_lists', 'starts');
}

//	function for start lists title
function show_start_lists_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']} - Starts</div>";
}


///////////////////////////////////////////////////////////////////////////////

//	add hook to show the starts of a specific list
add_action('show_starts', 'show_starts_func');

//	set the content for showing a specific starting list
//	set the title of the page
function show_starts_func() {
	global $SETTINGS;
	back_button();
	show_start_list_title();
	do_action('show_list', array($_GET['list'], $SETTINGS['starts_columns']));
}

function show_start_list_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']} - Startlijst: ".get_list_title(base64_decode($_GET['list']))."</div>";
}
