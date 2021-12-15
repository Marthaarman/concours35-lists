<?php 

add_action('html_head', 'starts_css');

function starts_css() {
	//echo "<link rel='stylesheet' type='text/css' href='assets/starts.css' />";
}


add_action('show_start_files', 'show_starts_func');

function show_starts_func() {
	show_starts_title();
	show_starts_lists();
}

function show_starts_title() {
	global $SETTINGS;
	echo "<div id='page_title'>{$SETTINGS['site_title']}</div>";
}

function show_starts_lists() {
	do_action('show_lists', 'starts');
}